<?php

namespace UniAlteri\MangoPayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MangoPayController
 * @package UniAlteri\MangoPayBundle\Controller
 * @Route("/mango-pay")
 */
class MangoPayController extends Controller
{
    /**
     * @Route("/card-registration/return/{registrationSessionId}", name="_unialteri_mangopay_card_regitration_return")
     * @param Request $request
     * @param string $registrationSessionId
     * @return Response
     * @throws NotFoundHttpException
     */
    public function cardRegistrationReturnAction(Request $request, $registrationSessionId)
    {
        $cardRegistrationService = $this->get('unialteri.mangopaybundle.service.card_registration');

        $getQuery = $request->query;

        $response = new Response();
        if ($getQuery->has('data')) {
            $cardRegistrationService->processMangoPayValidReturn($registrationSessionId, $getQuery->get('data'),$response);
        } else {
            $cardRegistrationService->processMangoPayError($registrationSessionId, $getQuery->get('errorCode'), $response);
        }

        return $response;
    }

    /**
     * @Route("/3dsecure/return", name="_unialteri_mangopay_secure_flow_return")
     * @param Request $request
     * @return Response
     * @throws NotFoundHttpException
     */
    public function secureFlowReturnAction(Request $request)
    {
        $secureFlowService = $this->get('unialteri.mangopaybundle.service.secure_flow');

        $getQuery = $request->query;

        $response = new Response();
        if ($getQuery->has('transactionId')) {
            $secureFlowService->processMangoPayReturn($getQuery->get('transactionId'),$response);
        }

        return $response;
    }
}