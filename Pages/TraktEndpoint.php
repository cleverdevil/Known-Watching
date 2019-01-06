<?php

    namespace IdnoPlugins\Watching\Pages {
        
        class TraktEndpoint extends \Idno\Common\Page 
        {
            
            function post()
            {
                $this->setResponse(500);
                \Idno\Core\Idno::site()->triggerEvent('watching/post/start', ['page' => $this]);
                $this->postCreate();
            }

            function postCreate()
            {
                $payload = $this->getInput('payload');
                $json = json_decode($payload);
                
                $this->setInput('title', $json->title);
                $this->setInput('body', $json->summary);
                $this->setInput('watchType', $json->type);
                $this->setInput('player', 'Trakt');
                $this->setInput('mediaURL', $json->link);
                
                $contentType = new \IdnoPlugins\Watching\ContentType();
                    
                $entity = $contentType->createEntity();
                $entity->setOwner('http://cleverdevil.io/profile/cleverdevil');
                
                $result = $entity->saveDataFromInput();
                if ($result) {
                    \Idno\Core\Idno::site()->triggerEvent('watching/post/success', ['page' => $this, 'object' => $entity]);
                    $this->setResponse(201);
                    header('Location: ' . $entity->getURL());
                    exit();
                } else {
                    $this->setResponse(500);
                    exit();
                } 
            }

        }

    }
?>
