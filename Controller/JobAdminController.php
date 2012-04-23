<?php

namespace COil\Jobeet2Bundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

/**
 * Controller for frontend admin action.
 */
class JobAdminController extends Controller
{
    /**
     * Admin batch process to extend Job validity. A job can only be extented
     * if it expires soon.
     *
     * @return RedirectResponse
     */
    function batchActionExtend()
    {
        $request    = $this->getRequest();
        $batchInfos = json_decode($request->request->get('data'), true);
        $jobIds     = $batchInfos['idx'];

        if (empty($jobIds)) {
            throw $this->createNotFoundException('Error, nothing to extend.');
        }

        $em = $this->getDoctrine()->getEntityManager();

        $count = 0;
        foreach ($jobIds as $id)
        {
            $job = $em->getRepository('Jobeet2Bundle:Job')->find($id);
            if ($job->expiresSoon()) {
                $job->extend($this->container->getParameter('jobeet2.active_days'));
                $em->persist($job);
                $em->flush();
                $count++;
            }
        }

        $notProcessed = count($jobIds) - $count;

        // Set confimation message and redirect
        if (0 == $count) {
            $this->get('session')->setFlash('sonata_flash_error', 'flash_batch_extend_nothing_done');
        }
        elseif ($count ==  count($jobIds)) {
            $this->get('session')->setFlash('sonata_flash_success', 'flash_batch_extend_success', array(
                '%count%' => $count,
            ));
        }
        else {
            $this->get('session')->setFlash('sonata_flash_info', 'flash_batch_extend_partial_success', array(
                '%count%'         => $count,
                '%$notProcessed%' => $notProcessed
            ));
        }

        return $this->redirect($this->admin->generateUrl('list', $this->admin->getFilterParameters()));
    }
}