<?php
/**
 *
 * @package    YoloTheme
 * @version    1.0.0
 * @author     Administrator <admin@yolotheme.com>
 * @copyright  Copyright (c) 2015, YoloTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://yolotheme.com
 */

$yolo_options = yolo_get_options();

?>
<div id="switch-style-selector">
    <div class="switch-wrapper">
        <div class="switch-selector-open"><i class="fa fa-cog fa-spin"></i></div>
        <div class="switch-selector-scroll">
            <div class="switch-selector-buynow">
                <a href="#" class="switch-selector-button-buynow"
                   target="_blank"><?php esc_html_e('Purchase Now', 'yolo-motor'); ?></a>
            </div>
            <div class="switch-selector-body clearfix">
                <section class="switch-selector-section clearfix">
                    <h3 class="switch-selector-title"><?php esc_html_e('Primary Color', 'yolo-motor'); ?></h3>

                    <div class="switch-selector-row clearfix">
                        <ul class="switch-primary-color">
                            <li class="active" style="background-color: #ffb535" data-color="#ffb535"></li>
                            <li style="background-color: #eb4947" data-color="#eb4947"></li>
                            <li style="background-color: #2bb673" data-color="#2bb673"></li>
                            <li style="background-color: #22b8f0" data-color="#22b8f0"></li>
                            <li style="background-color: #00f0d7" data-color="#00f0d7"></li>
                        </ul>
                    </div>
                </section>

                <section class="switch-selector-section clearfix">
                    <h3 class="switch-selector-title"><?php esc_html_e('Layout', 'yolo-motor'); ?></h3>

                    <div class="switch-selector-row clearfix">
                        <a data-type="layout" data-value="wide" href="#"
                           class="switch-selector-btn"><?php esc_html_e('Wide', 'yolo-motor'); ?></a>
                        <a data-type="layout" data-value="boxed" href="#"
                           class="switch-selector-btn"><?php esc_html_e('Boxed', 'yolo-motor'); ?></a>
                    </div>
                </section>
                <section class="switch-selector-section clearfix switch-background">
                    <h3 class="switch-selector-title"><?php esc_html_e('Boxed Background', 'yolo-motor'); ?></h3>

                    <div class="switch-selector-row clearfix">
                        <ul class="switch-primary-background">
                            <li class="pattern-0" data-name="pattern-1.png" data-type="pattern"
                                style="background-position: 0px 0px;"></li>
                            <li class="pattern-1" data-name="pattern-2.png" data-type="pattern"
                                style="background-position: -50px 0px;"></li>
                            <li class="pattern-2" data-name="pattern-3.png" data-type="pattern"
                                style="background-position: -100px 0px;"></li>
                            <li class="pattern-3" data-name="pattern-4.png" data-type="pattern"
                                style="background-position: -146px 0px;"></li>
                            <li class="pattern-4" data-name="pattern-5.png" data-type="pattern"
                                style="background-position: -190px 0px;"></li>
                            <li class="pattern-5" data-name="pattern-6.png" data-type="pattern"
                                style="background-position: -240px 0px;"></li>
                            <li class="pattern-6" data-name="pattern-7.png" data-type="pattern"
                                style="background-position: -289px 0px;"></li>
                            <li class="pattern-7" data-name="pattern-8.png" data-type="pattern"
                                style="background-position: -340px 0px;"></li>
                            <li class="pattern-8" data-name="pattern-9.png" data-type="pattern"
                                style="background-position: -385px 0px;"></li>
                            <li class="pattern-9" data-name="pattern-10.png" data-type="pattern"
                                style="background-position: -436px 0px;"></li>
                        </ul>
                    </div>
                </section>
                <section class="switch-selector-section clearfix">
                    <div class="switch-selector-row clearfix">
                        <a id="switch-selector-reset" href="#"
                           class="switch-selector-btn"><?php esc_html_e('Reset', 'yolo-motor'); ?></a>
                    </div>
                </section>
            </div>

            <div class="switch-selector-demos clearfix">
                <section class="switch-selector-section clearfix">
                    <h3 class="switch-selector-title"><?php esc_html_e('Demos', 'yolo-motor'); ?></h3>

                    <div class="yolo-sw-demos switch-selector-row clearfix">
                        <div class="yolo-sw-demo demo-home1">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home1</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home2">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-2/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home2</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home3">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-3/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home3</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home4">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-4/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home4</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home5">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-5/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home5</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home6">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-6/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home6</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home7">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-7/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home7</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home8">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-parallax/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home8</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home9">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-lookbook-v1/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home9</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home10">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-lookbook-v2/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home10</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                        <div class="yolo-sw-demo demo-home11">
                            <div class="yolo-sw-demo-wrapper">
                                <a class="yolo-sw-hover-overlay" href="http://demo.yolotheme.com/motor/home-lookbook-v3/"><span>LAUNCH DEMO</span></a>
                            </div>
                            <div class="yolo-sw-demo-title">Home11</div>
                            <div class="yolo-sw-demo-screenshot"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
</div>