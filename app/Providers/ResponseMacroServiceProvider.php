<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
	public function boot()
	{
		Response::macro('success', function ($data) {
			return Response::json([
				'errors'  => false,
				'data' => $data,
				]);
		});

		Response::macro('error', function ($data, $status = 400) {
	    	return Response::json([
				'errors'  => true,
				'data' => $data,
				], $status);
		});
	}
}