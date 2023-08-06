<?php

namespace App\Http\Controllers;

use App\Facade\Support\Tools\PdfHtml;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class VueController extends Controller
{
    public function __invoke(Request $request, $any = ''): view
    {
        if (str($any)->contains(['admin-panel', 'api', 'provider-panel'])) {
            abort(HttpResponse::HTTP_NOT_FOUND);
        }

        return view('Front.index');
    }

    public function pdfview($order_id): Response
    {
        $order = Order::find(base64_decode($order_id));

        $filename = 'Invoice-'.$order->order_no;

        return PdfHtml::stream('Front.pdfview', ['order' => $order, 'filename' => $filename], $filename);
    }
}
