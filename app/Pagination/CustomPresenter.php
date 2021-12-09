<?php

namespace App\Pagination;



use Illuminate\Support\HtmlString;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;

class CustomPresenter implements PresenterContract
{

    use BootstrapThreeNextPreviousButtonRendererTrait,UrlWindowPresenterTrait;

    protected $paginator;
    protected $window;

    public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator, 2) : $window->get();
    }

    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<div class="sayfalama">%s %s %s</div>',
                $this->getPreviousButton('<i class="fa fa-angle-left" aria-hidden="true"></i>'),
                $this->getLinks(),
                $this->getNextButton('<i class="fa fa-angle-right" aria-hidden="true"></i>')
            ));
        }

        return '';
    }

    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    protected function getDisabledTextWrapper($text)
    {
        return '<a class="say disabled">'.$text.'</a>';
    }

    protected function getActivePageWrapper($text)
    {
        return '<a class="say say_aktif">'.$text.'</a>';
    }

    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        $request = request()->create($url);

        if($request->has('page') && $request->get('page') == 1){
            $url = $request->url();
        }

        return '<a class="say" href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a>';
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }
}