<?php
namespace Rus\Includes;

use Rus\Helper\RusHelper;
/**
 * Index controller to handle home page for this plugin
 * 
 * @package    robust-user-search
 * @subpackage includes
 * @author     Smit Patel <smitpatel.dev@gmail.com>
 */
class RusIndexController {
    private static $instance;

    /**
     * Security Check
     *
     * @param null
     * @return null
     */
    public function __construct(){
        RusHelper::checkSecurity();
    }

    /**
     * Create a new instance and run register function
     *
     * @param null
     * @return null
     */
    public static function instance(){
        $instance = new self;
        $instance->register();
    }

    /**
     * Add specific styling to display icon
     *
     * @param null
     * @return null
     */
    public static function customFavicon() {
        echo "<style>
            .toplevel_page_rus img{
                margin-top:0px !important;
                padding-top:5px !important;
            }
            </style>"; 
    }

    /**
     * Adding main menu page to wordpress admin
     *
     * @param null
     * @return null
     */
    public function register() { 
        // add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '', string $icon_url = '', int $position = null ), 
        add_menu_page( 'Robust user search', 'Robust Search', RUS_CAPABILITY, 'rus', array( $this, 'indexOutput'), 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAJmSURBVHgBzVXdcdpAEN6VRJ7sMXRAOsBvGU8SKxVAKjCpAKcCoAKcCgwVBFdghXgyfgsdWKkADH4C6TbfciKWFMRPZjLjnZHmfna/b29vd4/oPwvvo+TLpGzIa2F4CZMpkfQXFA3uuRL+M4GCxuQ0iZw6lPxNOkIU4D9wKR4GXJnuRfBW5r5DXIdhE9NyAgVjHhiioc4cuwcdTvZpKsRDAdkdHweFBO/l6QFg1ayH5sYl0897aE/oNgBxkT0hhyM+el1AMJdk2HUouio6dl5AVsUdNTFs63zEx5tDrwQpko3yBmBFe5vsHTpAEMLWK/J+HmKzN4G/8lw6cG9MB8heBDbGpVsh02WSRzpAvF0KtsgUnL7oHOl48k5mzfW+UBzecSUost95AmRHW4vpOx9dIS0DJvMNp6jaj3sOef42+60EyIi2LTiD8WPHo7gRkTsc8UkHppotA6RkZxtGJkTwKkQIqlrNWpGGInjr/nouF75AW5gim85B2nQoPl3bnsmklgzHhQQo9RuAtBwyPqZBPrbnMq+b1chcLij+cJ8qxBKVWqIIxBmCTIgMOcNkubWpoABeRtzbCXi4XtcsA3RDx0tadgsJNCxiG1q5RN51ngCBqgk53Xybjq1uGd7383t/XbJL0WcEK9QGhlj3ssrRqWZTeg2J0LPNTsK894VyJk81GE5sb8mSpOVcZtdWZzZJXXJGeBuJR3JLqzeBwwUt/8Q9qeyv8Lqmb0WEO/nBlfFBBM9ALki4SqtHRVuFK9qTLLGEAP9YBL6TIEXS0RpIr2sy4L4+7ftm7BTtP4j1g35aiPRS5Dc2UTIXCVE7mwAAAABJRU5ErkJggg==', 25); 
    }


    /**
     * Display output for index page
     *
     * @param null
     * @return null
     */
    public function indexOutput() {
        wp_enqueue_style( 'rus-css', RUS_DIST_CSS_APP, array(), null, false);
        wp_enqueue_style( 'rus-fonts', RUS_FONTS, array(), null, false);
        wp_enqueue_script( 'rus-manifest', RUS_DIST_JS_MANIFEST, array(), null, true);
        wp_enqueue_script( 'rus-vendor', RUS_DIST_JS_VENDOR, array(), null, true);
        wp_enqueue_script( 'rus-app', RUS_DIST_JS_APP, array(), null, true);
        wp_localize_script('rus-app', 'rusN', array(
            'rootapiurl' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ));
        
        $allowed_html = array(
            'link' => array(
                'href' => array(),
                'rel' => array(),
            ),
            'div' => array(
                'id' => array(),
                'class' => array(),
                'style' => array()
            ),
            'app-layout' => array(),
            'style' => array()
        );
        echo wp_kses('
        <div class="flex flex-wrap antialiased font-sans" style="width:100% !important;">
            <div class="w-full flex flex-wrap mt-2">
                <div id="vueApp" class="w-full">
                    <app-layout/>
                </div>
            </div>
        </div>
        <style>
            .error, .settings-error, .notice{
                display:none !important;
            }
            #wpfooter{
                display: none !important;
            }
            body{
                background: #ffff !important;
            }
        </style>
        ', $allowed_html);
    }

}