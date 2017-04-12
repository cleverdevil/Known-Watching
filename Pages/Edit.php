<?php

    namespace IdnoPlugins\Watching\Pages {

        use Idno\Core\Autosave;

        class Edit extends \Idno\Common\Page {

            function getContent() {

                $this->createGatekeeper();    // This functionality is for logged-in users only

                // Are we loading an entity?
                if (!empty($this->arguments)) {
                    $object = \IdnoPlugins\Watching\Watching::getByID($this->arguments[0]);
                } else {
                    $object = new \IdnoPlugins\Watching\Watching();
                }

                $t = \Idno\Core\site()->template();
                $body = $t->__(array(
                    'object' => $object
                ))->draw('entity/Watching/edit');

                if (empty($vars['object']->_id)) {
                    $title = 'What are you watching?';
                } else {
                    $title = 'Edit what you watched';
                }

                if (!empty($this->xhr)) {
                    echo $body;
                } else {
                    $t->__(array('body' => $body, 'title' => $title))->drawPage();
                }
            }

            function postContent() {
                $this->createGatekeeper();

                $new = false;
                if (!empty($this->arguments)) {
                    $object = \IdnoPlugins\Watching\Watching::getByID($this->arguments[0]);
                }
                if (empty($object)) {
                    $object = new \IdnoPlugins\Watching\Watching();
                }

                if ($object->saveDataFromInput($this)) {
                    (new \Idno\Core\Autosave())->clearContext('watching');
                    $forward = $this->getInput('forward-to', $object->getDisplayURL());
                    $this->forward($forward);
                }

            }

        }

    }
