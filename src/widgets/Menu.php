<?php
namespace andresbreads\coreui\widgets;

use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * @package andresbreads\coreui\widgets
 *
 * For example,
 *
 * ```php
 * Menu::widget([
 *      'items' => [
 *          [
 *              'label' => 'Starter Pages',
 *              'icon' => 'tachometer-alt',
 *              'badge' => '<span class="right badge badge-info">2</span>',
 *              'items' => [
 *                  ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
 *                  ['label' => 'Inactive Page', 'iconStyle' => 'far'],
 *              ]
 *          ],
 *          ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
 *          ['label' => 'Yii2 PROVIDED', 'header' => true],
 *          ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
 *          ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
 *          ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
 *          ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
 *      ]
 * ])
 * ```
 *
 * @var array menu item
 * - label: string, the menu item label.
 * - header: boolean, not nav-item but nav-header when it is true.
 * - url: string or array, it will be processed by [[Url::to]].
 * - items: array, the sub-menu items.
 * - icon: string, the icon name. @see https://fontawesome.com/
 * - iconStyle: string, the icon style, such as fas(Solid), far(Regular), fal(Light), fad(Duotone), fab(Brands).
 * - iconClass: string, the whole icon class.
 * - iconClassAdded: string, the additional class.
 * - badge: string, html.
 * - target: string.
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a class="nav-link {submenuClass} {active}" href="{url}" {target}>{icon} {label}</a>';

    /**
     * @inheritdoc
     */
    public $labelTemplate = '{label} {badge}';

    /**
     * @var string submenu wrapper
     */
    public $submenuTemplate = "\n<ul class='nav-group-items'>\n{items}\n</ul>\n";

    /**
     * @var string
     */
    public static $iconDefault = 'circle';

    /**
     * @var string
     */
    public static $iconStyleDefault = 'fas';

    /**
     * @inheritdoc
     */
    public $itemOptions = ['class' => 'nav-item'];

    /**
     * @inheritdoc
     */
    public $activateParents = true;

    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'sidebar-nav',
        'data-coreui' => 'navigation',
        'data-simplebar' => '',
        'role' => 'menu',
    ];

    /**
     * {@inheritDoc}
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));

            if (isset($item['items'])) {
                Html::removeCssClass($options, 'nav-item');
                Html::addCssClass($options, 'nav-group');
            }

            if (isset($item['header']) && $item['header']) {
                Html::removeCssClass($options, 'nav-item');
                Html::addCssClass($options, 'nav-title');
            }

            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
                if ($item['active']) {
                    $options['class'] .= ' menu-open';
                }
            }

            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    /**
     * {@inheritDoc}
     */
    protected function renderItem($item)
    {
        if(isset($item['header']) && $item['header']) {
            return $item['label'];
        }

        if (isset($item['iconClass'])) {
            $iconClass = $item['iconClass'];
        } else {
            $iconStyle = $item['iconStyle'] ?? static::$iconStyleDefault;
            $icon = $item['icon'] ?? static::$iconDefault;
            $iconClassArr = ['nav-icon', $iconStyle, 'fa-'.$icon];
            isset($item['iconClassAdded']) && $iconClassArr[] = $item['iconClassAdded'];
            $iconClass = implode(' ', $iconClassArr);
        }
        $iconHtml = '<i class="'.$iconClass.'"></i>';

        $template = ArrayHelper::getValue($item, 'template', (isset($item['linkTemplate']))? $item['linkTemplate'] : $this->linkTemplate);
        return strtr($template, [
            '{label}' => strtr($this->labelTemplate, [
                '{label}' => $item['label'],
                '{badge}' => $item['badge'] ?? '',
            ]),
            '{submenuClass}' => isset($item['items']) ? 'nav-group-toggle' : '',
            '{url}' => isset($item['url']) ? Url::to($item['url']) : '#',
            '{icon}' => $iconHtml,
            '{active}' => $item['active'] ? $this->activeCssClass : '',
            '{target}' => isset($item['target']) ? 'target="'.$item['target'].'"' : ''
        ]);
    }
}