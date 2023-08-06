<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ direction() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <link rel="preconnect" href="http://fonts.googleapis.com">
    <link rel="preconnect" href="http://fonts.gstatic.com" crossorigin>
    <link href="http://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
</head>
<body style="padding: 0px; margin: 0px; box-sizing: border-box; direction: rtl; font-family: 'Tajawal', sans-serif;">
<div class="contain-div" style="border-radius: 15px; margin: 25px auto; padding: 30px;">
    <div class="container" style="margin-left: auto; margin-right: auto;">
        <div class="all-bill" style="border: 1px solid #5F634A; border-radius: 15px; padding: 40px 0px 20px;">
            <div style="margin-bottom: 20px; padding: 0px 40px 30px;">
                <div>
                    <div style="width: 30%; float: right">
                        <img src="{{ public_path('admin/images/rental-dark.png') }}" class="logo" alt="logo" style="height: 80px; object-fit: contain;">
                    </div>
                    <div style="width: 70%; margin-top: 20px;">
                        <h3 style="margin: 0px; font-size: 24px; color: #5F634A; font-weight: bold;">لتأجير معدات التصوير</h3>
                        <h5 style="margin: 15px 0px 0px;"><a href="#" style="text-decoration: none; color: #5F634A; font-size: 18px;">rental.sa</a></h5>
                    </div>
                </div>
            </div>
            <div class="order-details" style="padding: 35px 20px 20px; border-top: 1px solid #5F634A;">
                <div>
                    <div style="width: 50%; float: right;">
                        <div class="client-info" style="padding: 10px 15px;">
                            <h4 style="margin-top: 0px; font-weight: bold; font-size: 28px; margin-bottom: 25px;">بيانات الطلب</h4>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">الإسم:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ ucwords($order->user->full_name) }}</span>
                            </h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">رقم الجوال:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;" dir="ltr">{{ saudiPhone()->setPrefix($order->user->phone) }}</span>
                            </h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">المدينة:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ ucwords($order->user->city->name) }}</span>
                            </h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">حالة الدفع:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ trans('back.'.$order->payment_status) }}</span>
                            </h5>
                        </div>
                    </div>
                    <div style="width: 50%; float: left;">
                        <div class="order-info" style="padding: 10px 15px;">
                            <h4 style="margin-top: 0px; font-weight: bold; font-size: 28px; margin-bottom: 25px;">تفاصيل الطلب</h4>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">رقم الطلب:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ $order->order_no }}</span></h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">تاريخ
                                الإستلام: <span dir="{{ direction() }}" style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ localizeDate($order->start_date->format('d F Y')) }}</span></h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">تاريخ
                                التسليم: <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ localizeDate($order->end_date->format('d F Y')) }}</span></h5>
                            <h5 style="margin-top: 0px; font-weight: bold; font-size: 22px; margin-bottom: 15px; color: #5F634A;">حالة الطلب:
                                <span style="font-weight: lighter; font-size: 18px; color: #000; margin-inline-start: 10px;">{{ trans('back.'.$order->status) }}</span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="products table-responsive" style="padding: 15px 20px 15px;">
                <table class="table table-bordered" style="width: 100%; text-align: center; caption-side: bottom; border: 1px solid black; border-collapse: collapse;">
                    <thead style="color: #fff; background-color: #5F634A;">
                    <tr>
                        <th scope="col" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">إسم المنتج</th>
                        <th scope="col" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">الكمية</th>
                        <th scope="col" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">قيمة الإيجار</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order->products as $product)
                            <tr>
                                <th scope="row" style="text-align: center; border: 1px solid black; border-collapse: collapse;">{{ ucwords($product->pivot->product_name) }}</th>
                                <td style="padding: 10px 15px; border: 1px solid black; border-collapse: collapse;">{{ $product->pivot->product_qty }}</td>
                                <td style="padding: 10px 15px; border: 1px solid black; border-collapse: collapse;">{{ money($product->pivot->product_price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">اجمالي المبلغ بدون ضريبة</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ money($order->subtotal) }}</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">اجمالي الضريبة</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ money($order->tax) }}</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">اجمالي مبلغ التأمين</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ money($order->total_insurance) }}</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">اجمالي قيمة الخصم</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ money($order->dicount) }}</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">عدد ايام الايجار</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ $order->renting_days }}</th>
                    </tr>
                    <tr>
                        <th scope="col" colspan="2" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">الإجمالي</th>
                        <th scope="col" colspan="1" style="padding: 10px 15px; text-align: center; border: 1px solid black; border-collapse: collapse;">{{ money($order->total) }}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div class="footer" style="padding: 30px 20px 5px;">
                <h5 style="margin-top: -11px; margin-bottom: 0px; color: #5F634A; font-weight: bold; font-size: 22px; float: right;">الدعم الفني: <span style="color: #000; font-weight: lighter; margin-inline-start: 10px;" dir="ltr">{{ saudiPhone()->setPrefix(getSetting('contact_phone')) }}</span></h5>
                <h5 style="margin-top: -11px; margin-bottom: 0px; color: #5F634A; font-weight: bold; font-size: 22px; float: left;">البريد الإلكتروني: <span style="color: #000; font-weight: lighter; margin-inline-start: 10px;">{{ getSetting('contact_email') }}</span></h5>
            </div>
        </div>
    </div>
</div>
</body>
</html>
