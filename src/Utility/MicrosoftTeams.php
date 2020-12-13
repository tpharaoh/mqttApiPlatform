<?php


namespace App\Utility;


use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MicrosoftTeams
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function initiateClient(HttpClientInterface $client)
    {
        $this->client=$client;
    }

    public function sendNotification($url,$title,$message,$action)
    {
        $date=new \DateTime();
        echo '***'.$action;
        $json = '{
    "type": "message",
    "attachments":
    [
        {
            "contentType": "application/vnd.microsoft.card.adaptive",
            "contentUrl": null,
            "content":
            {
                "$schema": "http://adaptivecards.io/schemas/adaptive-card.json",
                "type": "AdaptiveCard",
                "version": "1.2",
                "body":
                [
                    {
                        "type": "TextBlock",
                        "size": "Medium",
                        "weight": "Bolder",
                        "text": "' . $title . '"
                    },
                    {
                        "type": "ColumnSet",
                        "columns":
                        [
                            {
                                "type": "Column",
                                "items":
                                [
                                    {
                                        "type": "TextBlock",
                                        "weight": "Bolder",
                                        "text": "' . $title . '",
                                        "wrap": true
                                    },
                                    {
                                        "type": "TextBlock",
                                        "spacing": "None",
                                        "text": "Created ' . $date->format('Y-m-d H:i:s') . '",
                                        "isSubtle": true,
                                        "wrap": true
                                    }
                                ],
                                "width": "stretch"
                            }
                        ]
                    },
                    {
                        "type": "TextBlock",
                        "text": "' . $message . '",
                        "wrap": true
                    }
                ]';
                if($action!=''){
                 $json.=',
                "actions":
                [
                    {
                        "type": "Action.OpenUrl",
                        "title": "View",
                        "url": "' . $action . '"
                    }
                ]';
                }
                $json.='
            }
        }
    ]
}';
        $client=HttpClient::create();

        $response=$client->request('POST',$url,[
            'body'=>$json,
            'headers'=>[
                'Content-Type'=>'application/json',

            ]
        ]);
        echo $json;
        var_dump($response->getInfo());

    }
}