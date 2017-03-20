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
            'url' => ''
        ];

        try {
            $this->validate($request, [
                'url' => 'required|url|min:5|max:2000'
            ]);
        } catch (ValidationException $e) {
            $vars['error'] = $e->getMessage();
            return view('main', $vars);
        }

        $url = Url::create([
            'url' => $request->get('url')
        ]);

        $vars['url'] = env('APP_DOMAIN') . '/' . $url->getTextId();

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
