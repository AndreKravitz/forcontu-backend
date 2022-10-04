<?php

/**
 * @file
 * Contains \Drupal\forcontu_pages\Controller\ForcontuPagesController.
 */

namespace Drupal\forcontu_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\user\UserInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

class ForcontuPagesController extends ControllerBase
{
    public function simple()
    {
        return [
            '#markup' => '<p>' . $this->t('This is a simple page (with no arguments)') .
                '</p>',
        ];
    }

    public function calculator($num1, $num2)
    {
        //a) comprobamos que los valores facilitados sean numéricos
        //y si no es así, lanzamos una excepción
        if (!is_numeric($num1) || !is_numeric($num2)) {
            throw new BadRequestHttpException(t('No numeric arguments specified.'));
        }
        //b) Los resultados se mostrarán en formato lista HTML (ul).
        //Cada elemento de la lista se añade a un array
        $total = $num1 + $num2;
        $list[] = "Addition: $num1 + $num2 = $total";
        //     "Addition: @num1 + @num2 = @sum",
        //     [
        //         '@num1' => $num1,
        //         '@num2' => $num2,
        //         '@sum' => $num1 + $num2
        //     ]
        // );
        $list[] = $this->t(
            "@num1 - @num2 = @difference",
            [
                '@num1' => $num1,
                '@num2' => $num2,
                '@difference' => $num1 - $num2
            ]
        );
        $list[] = $this->t(
            "@num1 x @num2 = @product",
            [
                '@num1' => $num1,
                '@num2' => $num2,
                '@product' => $num1 * $num2
            ]
        );
        //c) Evitar error de división por cero
        if ($num2 != 0)
            $list[] = $this->t(
                "@num1 / @num2 = @division",
                [
                    '@num1' => $num1,
                    '@num2' => $num2,
                    '@division' => $num1 / $num2
                ]
            );
        else
            $list[] = $this->t(
                "@num1 / @num2 = undefined (division by zero)",
                array('@num1' => $num1, '@num2' => $num2)
            );
        //d) Se transforma el array $list en una lista HTML (ul)
        $output['forcontu_pages_calculator'] = [
            '#theme' => 'item_list',
            '#items' => $list,
            '#title' => $this->t('Operations:'),
        ];
        //e) Se devuelve el array renderizable con la salida.
        return $output;
    }

    public function user(UserInterface $user)
    {
        $list[] = $this->t("Username: @username", ['@username' => $user->getAccountName()]);
        $list[] = $this->t("Email: @email",  ['@email' => $user->getEmail()]);
        $list[] = $this->t("Roles: @roles", ['@roles' => implode(', ', $user->getRoles())]);
        $list[] = $this->t("last accessed time: @lastaccess", array('@lastaccess' => \Drupal::service('date.formatter')->format($user->getLastAccessedTime(), 'short')));
        $output['forcontu_pages_user'] = [
            '#theme' => 'item_list',
            '#items' => $list,
            '#title' => $this->t('User data:'),
        ];

        return $output;
    }

    public function links()
    {
        //link to /admin/structure/block
        $url1 = Url::fromRoute('block.admin_display');
        $link1 = Link::fromTextAndUrl(t('Go to the Block administration page'), $url1);

        $list[] = $link1;

        $output['forcontu_pages_links'] = [
            '#theme' => 'item_list',
            '#items' => $list,
            '#title' => $this->t('Examples of links:'),
        ];

        return $output; 
    }

    public function tab1() {
        return ['#markup' => '<p>' . $this->t('this is the content of Tab 1') . '</p>',];
    }

    public function tab2() {
        return ['#markup' => '<p>' . $this->t('this is the content of Tab 2') . '</p>',];
    }

    public function tab3() {
        return ['#markup' => '<p>' . $this->t('this is the content of Tab 3') . '</p>',];
    }

    public function action1() {
        return ['#markup' => '<p>' . $this->t('this is the content of action 1') . '</p>',];
    }
}


