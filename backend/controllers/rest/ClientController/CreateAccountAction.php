<?php
/**
 * CreateAccountAction.php
 * @author Revin Roman
 * @link https://rmrevin.com
 */

namespace cookyii\modules\Client\backend\controllers\rest\ClientController;

use cookyii\Facade as F;

/**
 * Class CreateAccountAction
 * @package cookyii\modules\Client\backend\controllers\rest\ClientController
 */
class CreateAccountAction extends \cookyii\rest\Action
{

    /**
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        $client_id = (int)F::Request()->post('client_id');

        if (empty($client_id)) {
            throw new \yii\web\BadRequestHttpException;
        }

        /** @var \cookyii\modules\Client\resources\Client\Model $Client */
        $Client = $this->findModel($client_id);

        $Account = $Client->accountHelper->create();

        if ($Account->hasErrors()) {
            $result = [
                'result' => false,
                'message' => \Yii::t('cookyii.client', 'Failed to create account'),
                'errors' => $Account->getFirstErrors(),
            ];
        } else {
            $result = [
                'result' => true,
                'message' => \Yii::t('cookyii.client', 'Account created successfully'),
                'account_id' => $Account->id,
            ];
        }

        return $result;
    }
}