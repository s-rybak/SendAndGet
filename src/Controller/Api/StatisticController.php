<?php

/*
 * This file is part of the "Send And Get" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Api;

use App\Resource\ApiSuccessResponceResource;
use App\Service\SiteStatisticServiceIntervace;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StatisticController extends FOSRestController
{
    private $appApi;
    private $statSerice;

    public function __construct(TokenStorageInterface $token, SiteStatisticServiceIntervace $statService)
    {
        $this->appApi = $token->getToken()->getUser();
        $this->statSerice = $statService;
    }

    /**
     * Get App statistic.
     *
     * @return View
     *
     * @Rest\Get("/app/stat")
     */
    public function getAppStatistic(): View
    {
        return $this->view(
            new ApiSuccessResponceResource($this->statSerice->getAppStistic($this->appApi->getId())),
            Response::HTTP_OK);
    }
}
