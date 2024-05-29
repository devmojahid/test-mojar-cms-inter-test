<?php

namespace Modules\Core\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

trait ResponseMessage
{

    public function response(array $data, bool $status): JsonResponse|RedirectResponse
    {
        if (!is_array($data)) {
            $data = [$data];
        }

        if (request()->has('redirect')) {
            $data['redirect'] = request()->input('redirect');
        }

        if (request()->ajax() || request()->isJson()) {
            return response()->json(
                [
                    'status' => $status,
                    'data' => $data
                ]
            );
        }

        if (!empty($data['redirect'])) {

            return redirect()->to($data['redirect']);
        }

        $data['status'] = $status ? 'success' : 'error';
        $back = back()->withInput()->with($data);

        if (empty($data['status'])) {
            $back->withErrors([$data['message']]);
        }

        return $back;
    }

    public function success(string|array $message): JsonResponse|RedirectResponse
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, true);
    }


    public function error(string|array $message): JsonResponse|RedirectResponse
    {
        if (is_string($message)) {
            $message = ['message' => $message];
        }

        return $this->response($message, false);
    }
}