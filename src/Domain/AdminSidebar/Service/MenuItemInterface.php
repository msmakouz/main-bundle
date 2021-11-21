<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\AdminSidebar\Service;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

interface MenuItemInterface
{
    public const ICON_3D = 'cil-3d';
    public const ICON_4K = 'cil-4k';
    public const ICON_LOGOUT = 'cil-account-logout';
    public const ICON_ACTION_REDO = 'cil-action-redo';
    public const ICON_ACTION_UNDO = 'cil-action-undo';
    public const ICON_ADDRESS_BOOK = 'cil-address-book';
    public const ICON_AIRPLANE = 'cil-airplane-mode';
    public const ICON_AIRPLANE_MODE_OFF = 'cil-airplane-mode-off';
    public const ICON_AIRPLAY = 'cil-airplay';
    public const ICON_ALARM = 'cil-alarm';
    public const ICON_ALBUM = 'cil-album';
    public const ICON_ALIGN_CENTER = 'cil-align-center';
    public const ICON_ALIGN_LEFT = 'cil-align-left';
    public const ICON_ALIGN_RIGHT = 'cil-align-right';
    public const ICON_AMERICAN_FOOTBALL = 'cil-american-football';
    public const ICON_ANIMAL = 'cil-animal';
    public const ICON_APERTURE = 'cil-aperture';
    public const ICON_APPLE = 'cil-apple';
    public const ICON_APPLICATIONS = 'cil-applications';
    public const ICON_APPLICATIONS_SETTINGS = 'cil-applications-settings';
    public const ICON_ARROW_BOTTOM = 'cil-arrow-bottom';
    public const ICON_ARROW_CIRCLE_BOTTOM = 'cil-arrow-circle-bottom';
    public const ICON_ARROW_CIRCLE_LEFT = 'cil-arrow-circle-left';
    public const ICON_ARROW_CIRCLE_RIGHT = 'cil-arrow-circle-right';
    public const ICON_ARROW_CIRCLE_TOP = 'cil-arrow-circle-top';
    public const ICON_ARROW_LEFT = 'cil-arrow-left';
    public const ICON_ARROW_RIGHT = 'cil-arrow-right';
    public const ICON_ARROW_THICK_BOTTOM = 'cil-arrow-thick-bottom';
    public const ICON_ARROW_THICK_FROM_BOTTOM = 'cil-arrow-thick-from-bottom';
    public const ICON_ARROW_THICK_FROM_LEFT = 'cil-arrow-thick-from-left';
    public const ICON_ARROW_THICK_FROM_RIGHT = 'cil-arrow-thick-from-right';
    public const ICON_ARROW_THICK_FROM_TOP = 'cil-arrow-thick-from-top';
    public const ICON_ARROW_THICK_LEFT = 'cil-arrow-thick-left';
    public const ICON_ARROW_THICK_RIGHT = 'cil-arrow-thick-right';
    public const ICON_ARROW_THICK_TO_BOTTOM = 'cil-arrow-thick-to-bottom';
    public const ICON_ARROW_THICK_TO_LEFT = 'cil-arrow-thick-to-left';
    public const ICON_ARROW_THICK_TO_RIGHT = 'cil-arrow-thick-to-right';
    public const ICON_ARROW_THICK_TO_TOP = 'cil-arrow-thick-to-top';
    public const ICON_ARROW_THICK_TOP = 'cil-arrow-thick-top';
    public const ICON_ARROW_TOP = 'cil-arrow-top';
    public const ICON_ASSISTIVE_LISTENING_SYSTEM = 'cil-assistive-listening-system';
    public const ICON_ASTERISK = 'cil-asterisk';
    public const ICON_ASTERISK_CIRCLE = 'cil-asterisk-circle';
    public const ICON_AT = 'cil-at';
    public const ICON_AUDIO = 'cil-audio';
    public const ICON_AUDIO_DESCRIPTION = 'cil-audio-description';
    public const ICON_AUDIO_SPECTRUM = 'cil-audio-spectrum';
    public const ICON_AV_TIMER = 'cil-av-timer';
    public const ICON_BABY = 'cil-baby';
    public const ICON_BABY_CARRIAGE = 'cil-baby-carriage';
    public const ICON_BACKSPACE = 'cil-backspace';
    public const ICON_BADGE = 'cil-badge';
    public const ICON_BALANCE_SCALE = 'cil-balance-scale';
    public const ICON_BAN = 'cil-ban';
    public const ICON_BANK = 'cil-bank';
    public const ICON_BAR_CHART = 'cil-bar-chart';
    public const ICON_BARCODE = 'cil-barcode';
    public const ICON_BASEBALL = 'cil-baseball';
    public const ICON_BASKET = 'cil-basket';
    public const ICON_BASKETBALL = 'cil-basketball';
    public const ICON_BATH = 'cil-bath';
    public const ICON_BATTERY_0 = 'cil-battery-0';
    public const ICON_BATTERY_3 = 'cil-battery-3';
    public const ICON_BATTERY_5 = 'cil-battery-5';
    public const ICON_BATTERY_ALERT = 'cil-battery-alert';
    public const ICON_BATTERY_EMPTY = 'cil-battery-empty';
    public const ICON_BATTERY_SLASH = 'cil-battery-slash';
    public const ICON_BEACH_ACCESS = 'cil-beach-access';
    public const ICON_BEAKER = 'cil-beaker';
    public const ICON_BED = 'cil-bed';
    public const ICON_BELL = 'cil-bell';
    public const ICON_BIKE = 'cil-bike';
    public const ICON_BIRTHDAY_CAKE = 'cil-birthday-cake';
    public const ICON_BLIND = 'cil-blind';
    public const ICON_BLUETOOTH = 'cil-bluetooth';
    public const ICON_BLUR = 'cil-blur';
    public const ICON_BLUR_CIRCULAR = 'cil-blur-circular';
    public const ICON_BLUR_LINEAR = 'cil-blur-linear';
    public const ICON_BOAT_ALT = 'cil-boat-alt';
    public const ICON_BOLD = 'cil-bold';
    public const ICON_BOLT = 'cil-bolt';
    public const ICON_BOOK = 'cil-book';
    public const ICON_BOOKMARK = 'cil-bookmark';
    public const ICON_BORDER_ALL = 'cil-border-all';
    public const ICON_BORDER_BOTTOM = 'cil-border-bottom';
    public const ICON_BORDER_CLEAR = 'cil-border-clear';
    public const ICON_BORDER_HORIZONTAL = 'cil-border-horizontal';
    public const ICON_BORDER_INNER = 'cil-border-inner';
    public const ICON_BORDER_LEFT = 'cil-border-left';
    public const ICON_BORDER_OUTER = 'cil-border-outer';
    public const ICON_BORDER_RIGHT = 'cil-border-right';
    public const ICON_BORDER_STYLE = 'cil-border-style';
    public const ICON_BORDER_TOP = 'cil-border-top';
    public const ICON_BORDER_VERTICAL = 'cil-border-vertical';
    public const ICON_BOWLING = 'cil-bowling';
    public const ICON_BRAILLE = 'cil-braille';
    public const ICON_BRIEFCASE = 'cil-briefcase';
    public const ICON_BRIGHTNESS = 'cil-brightness';
    public const ICON_BRITISH_POUND = 'cil-british-pound';
    public const ICON_BROWSER = 'cil-browser';
    public const ICON_BRUSH = 'cil-brush';
    public const ICON_BRUSH_ALT = 'cil-brush-alt';
    public const ICON_BUG = 'cil-bug';
    public const ICON_BUILDING = 'cil-building';
    public const ICON_BULLHORN = 'cil-bullhorn';
    public const ICON_BURGER = 'cil-burger';
    public const ICON_BUS_ALT = 'cil-bus-alt';
    public const ICON_CALCULATOR = 'cil-calculator';
    public const ICON_CALENDAR = 'cil-calendar';
    public const ICON_CALENDAR_CHECK = 'cil-calendar-check';
    public const ICON_CAMERA = 'cil-camera';
    public const ICON_CAMERA_CONTROL = 'cil-camera-control';
    public const ICON_CAMERA_ROLL = 'cil-camera-roll';
    public const ICON_CAR_ALT = 'cil-car-alt';
    public const ICON_CARET_BOTTOM = 'cil-caret-bottom';
    public const ICON_CARET_LEFT = 'cil-caret-left';
    public const ICON_CARET_RIGHT = 'cil-caret-right';
    public const ICON_CARET_TOP = 'cil-caret-top';
    public const ICON_CART = 'cil-cart';
    public const ICON_CASH = 'cil-cash';
    public const ICON_CASINO = 'cil-casino';
    public const ICON_CAST = 'cil-cast';
    public const ICON_CAT = 'cil-cat';
    public const ICON_CC = 'cil-cc';
    public const ICON_CENTER_FOCUS = 'cil-center-focus';
    public const ICON_CHART = 'cil-chart';
    public const ICON_CHART_LINE = 'cil-chart-line';
    public const ICON_CHART_PIE = 'cil-chart-pie';
    public const ICON_CHAT_BUBBLE = 'cil-chat-bubble';
    public const ICON_CHECK = 'cil-check';
    public const ICON_CHECK_ALT = 'cil-check-alt';
    public const ICON_CHEVRON_BOTTOM = 'cil-chevron-bottom';
    public const ICON_CHEVRON_CIRCLE_DOWN_ALT = 'cil-chevron-circle-down-alt';
    public const ICON_CHEVRON_CIRCLE_LEFT_ALT = 'cil-chevron-circle-left-alt';
    public const ICON_CHEVRON_CIRCLE_RIGHT_ALT = 'cil-chevron-circle-right-alt';
    public const ICON_CHEVRON_CIRCLE_UP_ALT = 'cil-chevron-circle-up-alt';
    public const ICON_CHEVRON_DOUBLE_DOWN = 'cil-chevron-double-down';
    public const ICON_CHEVRON_DOUBLE_LEFT = 'cil-chevron-double-left';
    public const ICON_CHEVRON_DOUBLE_RIGHT = 'cil-chevron-double-right';
    public const ICON_CHEVRON_DOUBLE_UP = 'cil-chevron-double-up';
    public const ICON_CHEVRON_DOUBLE_UP_ALT = 'cil-chevron-double-up-alt';
    public const ICON_CHEVRON_LEFT = 'cil-chevron-left';
    public const ICON_CHEVRON_RIGHT = 'cil-chevron-right';
    public const ICON_CHEVRON_TOP = 'cil-chevron-top';
    public const ICON_CHILD = 'cil-child';
    public const ICON_CHILD_FRIENDLY = 'cil-child-friendly';
    public const ICON_CIRCLE = 'cil-circle';
    public const ICON_CLEAR_ALL = 'cil-clear-all';
    public const ICON_CLIPBOARD = 'cil-clipboard';
    public const ICON_CLOCK = 'cil-clock';
    public const ICON_CLONE = 'cil-clone';
    public const ICON_CLOUD = 'cil-cloud';
    public const ICON_CLOUD_DOWNLOAD = 'cil-cloud-download';
    public const ICON_CLOUD_UPLOAD = 'cil-cloud-upload';
    public const ICON_CLOUDY = 'cil-cloudy';
    public const ICON_CODE = 'cil-code';
    public const ICON_COFFEE = 'cil-coffee';
    public const ICON_COG = 'cil-cog';
    public const ICON_COLOR_BORDER = 'cil-color-border';
    public const ICON_COLOR_FILL = 'cil-color-fill';
    public const ICON_COLOR_PALETTE = 'cil-color-palette';
    public const ICON_COLUMNS = 'cil-columns';
    public const ICON_COMMENT_BUBBLE = 'cil-comment-bubble';
    public const ICON_DESCRIPTION = 'cil-description';
    public const ICON_SPEEDOMETER = 'cil-speedometer';
    public const ICON_LAYERS = 'cil-layers';
    public const ICON_SETTINGS = 'cil-settings';
    public const ICON_PEOPLE = 'cil-people';
    public const ICON_WALLET = 'cil-wallet';
    public const ICON_LIBRARY_ADD = 'cil-library-add';
    public const ICON_NOTE = 'cil-notes';
    public const ICON_PLUS = 'cil-plus';

    public static function createTitle(string $title, int $sort, UrlGeneratorInterface $router): MenuItemInterface;

    public function isTitle(): bool;

    public function sort(int $sort): self;

    public function icon(string $icon): self;

    public function url(string $url): self;

    public function generateUrl(string $routeName, array $parameters = []): self;

    public function addChildren(string $name): self;

    public function getName(): ?string;

    public function getUrl(): ?string;

    public function getIcon(): ?string;

    public function getSort(): int;

    public function getChildren(): ?array;

    public function getMenuItem(string $identifier): self;
}
