<?php

    namespace IdnoPlugins\Watching {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                \Idno\Core\site()->routes()->addRoute('/watching/edit/?', '\IdnoPlugins\Watching\Pages\Edit');
                \Idno\Core\site()->routes()->addRoute('/watching/edit/([A-Za-z0-9]+)/?', '\IdnoPlugins\Watching\Pages\Edit');
                \Idno\Core\site()->routes()->addRoute('/watching/delete/([A-Za-z0-9]+)/?', '\IdnoPlugins\Watching\Pages\Delete');
                \Idno\Core\site()->routes()->addRoute('/watching/([A-Za-z0-9]+)/.*', '\Idno\Pages\Entity\View');
                \Idno\Core\site()->routes()->addRoute('/watching/webhook/', '\IdnoPlugins\Watching\Pages\Endpoint', true);
                \Idno\Core\site()->routes()->addRoute('/watching/trakt/', '\IdnoPlugins\Watching\Pages\TraktEndpoint', true);
            }

            /**
             * Get the total file usage
             * @param bool $user
             * @return int
             */
            function getFileUsage($user = false) {

                $total = 0;

                if (!empty($user)) {
                    $search = ['user' => $user];
                } else {
                    $search = [];
                }

                if ($watchings = watching::get($search,[],9999,0)) {
                    foreach($watchings as $watching) {
                        if ($watching instanceof watching) {
                            if ($attachments = $watching->getAttachments()) {
                                foreach($attachments as $attachment) {
                                    $total += $attachment['length'];
                                }
                            }
                        }
                    }
                }

                return $total;
            }

        }

    }
