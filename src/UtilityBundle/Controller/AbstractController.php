<?php

namespace UtilityBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;

abstract class AbstractController extends Controller
{
    /**
     * @var array
     */
    protected $entityManagers = array();

    /**
     * wrapper function for UtilityBUndle:JsonResponseHelper.
     *
     * @param bool   $success
     * @param string $message
     * @param int    $status
     * @param array  $additionalData
     * @param array  $headers
     * @param string $translationDomain
     *
     * @return JsonResponse
     */
    protected function createJsonResponse(
        $success,
        $message,
        $status = 200,
        $additionalData = array(),
        $headers = array(),
        $translationDomain = 'ajax'
    ) {
        return $this->get('utility.json_response')
            ->createJsonResponse($success, $message, $status, $additionalData, $headers, $translationDomain);
    }

    /**
     * @param mixed                     $data
     * @param bool                      $success
     * @param string                    $message
     * @param int                       $status
     * @param array                     $headers
     * @param string                    $translationDomain
     * @param null|SerializationContext $serializationContext
     *
     * @return Response
     */
    public function createJmsResponse(
        $data,
        $success = true,
        $message = '',
        $status = 200,
        $headers = array(),
        $translationDomain = 'ajax',
        SerializationContext $serializationContext = null
    ) {
        return $this->get('utility.json_response')
            ->createJmsResponse(
                $data,
                $success,
                $message,
                $status,
                $headers,
                $translationDomain,
                $serializationContext
            );
    }

    /**
     * @param string $name
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function getEm($name = 'default')
    {
        if (!isset($this->entityManagers[$name])) {
            $this->entityManagers[$name] = $this->getDoctrine()->getManager($name);
        }

        return $this->entityManagers[$name];
    }

    protected function isCsrfValid($token)
    {
        return $this->get('security.csrf.token_manager')->isTokenValid(new CsrfToken('unknown', $token));
    }

    /**
     * @param string $message
     */
    public function createAccessDeniedException($message = null, \Exception $previous = null)
    {
        if (!$message) {
            $message = $this->container->getParameter('http_access_denied');
        }

        return parent::createAccessDeniedException($message, $previous);
    }
}
