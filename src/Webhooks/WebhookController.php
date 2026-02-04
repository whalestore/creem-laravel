<?php

namespace Creem\Webhooks;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    protected WebhookHandler $handler;

    public function __construct(WebhookHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle(Request $request): Response
    {
        $payload = $request->all();
        $signature = $request->header('X-Creem-Signature', '');
        $secret = config('creem.webhook.secret', '');

        try {
            $this->handler->handle($payload, $signature, $secret);
            return response('OK', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
