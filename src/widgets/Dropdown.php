<?php
namespace andresbreads\coreui\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use Yii;

/**
 * {@inheritDoc}
 */
class Dropdown extends \yii\bootstrap5\Dropdown
{
    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'dropdown-menu-end pt-0',
    ];

    /**
     * @inheritdoc
     */
    protected function renderItems(array $items, array $options = []): string
    {
        $lines = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = ($item === '-')
                    ? Html::tag('div', '', ['class' => 'dropdown-divider'])
                    : ($item === 'logout' ? $this->renderLogout() : $item);
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = $item['encode'] ?? $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $active = ArrayHelper::getValue($item, 'active', false);
            $disabled = ArrayHelper::getValue($item, 'disabled', false);

            Html::addCssClass($linkOptions, ['widget' => 'dropdown-item']);
            if ($disabled) {
                ArrayHelper::setValue($linkOptions, 'tabindex', '-1');
                ArrayHelper::setValue($linkOptions, 'aria.disabled', 'true');
                Html::addCssClass($linkOptions, ['disable' => 'disabled']);
            } elseif ($active) {
                ArrayHelper::setValue($linkOptions, 'aria.current', 'true');
                Html::addCssClass($linkOptions, ['activate' => 'active']);
            }

            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $headerContent = Html::tag('div', $label, ['class' => 'fw-semibold']);
                    $content = Html::tag('div', $headerContent, ['class' => 'dropdown-header bg-light py-2']);
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
                $lines[] = $content;
            } else {
                $submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                Html::addCssClass($submenuOptions, ['widget' => 'dropdown-submenu dropdown-menu']);
                Html::addCssClass($linkOptions, ['toggle' => 'dropdown-toggle']);

                $lines[] = Html::beginTag('div', array_merge_recursive(['class' => ['dropdown'], 'aria' => ['expanded' => 'false']], $itemOptions));
                $lines[] = Html::a($label, $url, array_merge_recursive([
                    'data' => ['bs-toggle' => 'dropdown'],
                    'aria' => ['expanded' => 'false'],
                    'role' => 'button',
                ], $linkOptions));
                $lines[] = static::widget([
                    'items' => $item['items'],
                    'options' => $submenuOptions,
                    'submenuOptions' => $submenuOptions,
                    'encodeLabels' => $this->encodeLabels,
                ]);
                $lines[] = Html::endTag('div');
            }
        }

        return Html::tag('div', implode("\n", $lines), $options);
    }

    /**
     * Renders Logout form
     *
     * @return string
     */
    protected function renderLogout() : string
    {
        return Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton('<i class="fas fa-sign-out-alt me-2"></i>' . Yii::t('app', 'Logout'), ['class' => 'dropdown-item logout'])
            . Html::endForm();
    }
}