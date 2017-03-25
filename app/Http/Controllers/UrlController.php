<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UrlController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $vars = [
            'error' => '',
            'url' => '',
            'shortcut_url' => ''
        ];

        try {
            $this->validate($request, [
                'url' => 'required|url|min:5|max:2000'
            ]);
        } catch (ValidationException $e) {
            $vars['error'] = $e->getMessage();
            return view('main', $vars);
        }

        $url = $request->get('url');

        if (($components = Url::toComponents($url)) !== false) {
            $urlString = Url::toUrlString($components);
            $url_model = Url::create(['url' => $urlString]);
            $vars['shortcut_url'] = env('APP_DOMAIN') . '/' . $url_model->getTextId();
            $vars['url'] = $urlString;
        } else {
            $vars['error'] = 'Invalid URL submitted!';
        }

        return view('main', $vars);
    }

    public function redirect($id)
    {
        $id = Url::convertToInt($id);
        $res = Url::find($id);

        if ($res) {
            return redirect($res->url);
        }

        return redirect('/');
    }
}
