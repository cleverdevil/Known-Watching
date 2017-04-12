<?php

    namespace IdnoPlugins\Watching\Pages {
        
        class Endpoint extends \Idno\Common\Page 
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
                $hook = json_decode($payload);

                if ($hook->Account->id != 1)
                {
                    exit();
                }

                if ($hook->event == 'media.play')
                {
                    $title = '';
                    $watchType = '';
                    $player = $hook->Player->title;
                    $body = $hook->Metadata->summary;
                    
                    if ($hook->Metadata->type == 'movie')
                    {
                        $watchType = 'movie';
                        $title = $hook->Metadata->title;
                    } else if ($hook->Metadata->type == 'episode')
                    {
                        $watchType = 'tv';
                        $title = $hook->Metadata->grandparentTitle . ", " . $hook->Metadata->parentTitle . " - " . $hook->Metadata->title;
                    }

                    $this->setInput('body', $body);
                    $this->setInput('title', $title);
                    $this->setInput('watchType', $watchType);
                    $this->setInput('player', $player);
                    
                    $_FILES['photo'] = $_FILES['thumb'];

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

    }
?>
