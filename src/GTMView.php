<?php

/**
 * Front end code generation class
 *
 * @package cyber-duck/laravel-google-tag-manager
 * @license MIT License https://github.com/cyber-duck/laravel-google-tag-manager/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 **/
namespace CyberDuck\LaravelGoogleTagManager;

class GTMView
{
    /**
     * Return the Tag Manager code
     *
     * @param string $id   The container ID
     * @param string $data The dataLayer
     * @return string
     */
    public function render($id, $data, $useIframe = false)
    {
        if (!config('gtm.enabled')) {
            return '';
        }

        return $useIframe ? $this->renderIframe($id) : $this->renderJs($id, $data);
    }

    public function renderJs($id, $data)
    {
        return '<script>window.dataLayer = window.dataLayer || [];'.$data.'</script>'
            .'<!-- Google Tag Manager -->'
            .'<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':'
            .'new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],'
            .'j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src='
            .'\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);'
            .'})(window,document,\'script\',\'dataLayer\',\'GTM-'.$id.'\');</script>'
            .'<!-- End Google Tag Manager -->';
    }


    public function renderIframe($id)
    {
        return '<!-- Google Tag Manager -->'
            .'<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-'.$id.'"'
            .'height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>'
            .'<!-- End Google Tag Manager -->';
    }
}
