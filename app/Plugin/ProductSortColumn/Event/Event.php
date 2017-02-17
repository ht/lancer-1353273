<?php
/*
 * This file is part of the ProductSortColumn
 *
 * Copyright(c) 2017 izayoi256 All Rights Reserved.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ProductSortColumn\Event;

use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class Event extends CommonEvent
{
    /** @var FormView */
    protected $adminProductEditFormView;

    /**
     * @param EventArgs $event
     */
    public function onAdminProductEditComplete($event)
    {
        $app = $this->app;
        $form = $event->getArgument('form');
        $Product = $event->getArgument('Product');
        $ProductSort = $form['ProductSort']->getData();
        $ProductSort->setProduct($Product);
        $app['orm.em']->persist($ProductSort);
        $app['orm.em']->flush();
    }

    /**
     * @param TemplateEvent $event
     */
    public function onAdminProductEditRender($event)
    {
        $parameters = $event->getParameters();
        $this->adminProductEditFormView = $parameters['form'];
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onAdminProductEditRenderBefore($event)
    {
        $form = $this->adminProductEditFormView;
        if (is_null($form)) {
            return;
        }

        $app = $this->app;

        $response = $event->getResponse();
        $html = $response->getContent();

        /** @var \DOMDocument $dom */
        /** @var \DOMDocumentFragment $template */
        /** @var \DOMXPath $xpath */
        /** @var \DOMNode $node */
        extract($this->initDomParser($html));

        $parameters = compact('form');
        $twig = $app->renderView('ProductSortColumn/Resource/template/admin/Product/snippet_product_sort.twig', $parameters);
        $template->appendXML($twig);

        $element = $xpath->query('id("detail_tag_box")')->item(0);
        if ($element) {
            $element->parentNode->insertBefore($node, $element->nextSibling);
        }

        $response->setContent(mb_convert_encoding($dom->saveHTML(), 'UTF-8', 'HTML-ENTITIES'));
        $event->setResponse($response);
    }
}
