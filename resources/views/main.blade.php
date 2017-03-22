@extends('layout')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column col-sm-12 col-md-10 col-lg-8 col-xl-6 col-4 centered">
                <div class="panel">
                    <div class="panel-header text-center">
                        <div class="panel-title">URL Shortener</div>
                    </div>
                    <div class="panel-body">
                        @if(!empty($error))
                            <div class="columns">
                                <div class="column col-12 text-center">
                                    <span style="color:#e60000">{{ $error }}</span>
                                </div>
                            </div>
                        @endif
                        <form method="post">
                            <div class="form-group">
                                <label class="form-label" for="input-url">URL</label>
                                <textarea class="form-input" id="input-url" rows="3" name="url"></textarea>
                            </div>
                            <div class="input-group">
                                <input type="submit" class="btn btn-primary input-group-btn btn-sm" value="Get shorter URL">
                                <input type="text" class="form-input input-sm" value="{{ $url ?? '' }}" readonly>
                                <button class="btn btn-primary input-group-btn btn-sm"><i class="fa fa-clipboard" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer text-center">
                        Created by <a href="https://github.com/Richardds" target="_blank">Richard Boldiš</a> with power of <a href="https://lumen.laravel.com/" target="_blank">Lumen</a> & <a href="https://picturepan2.github.io/spectre/index.html" target="_blank">Spectre.css</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
