<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="margin:0;padding:0;background:#f5f7fa;font-family:Arial,sans-serif;">

    ```
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 15px;">

                <table width="650" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 10px rgba(0,0,0,.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:#0d6efd;padding:25px;text-align:center;color:#fff;">
                            <h1 style="margin:0;font-size:28px;">
                                OneTech
                            </h1>
                            <p style="margin:10px 0 0;">
                                Order Confirmation
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0;color:#222;">
                                Thank you for your order
                            </h2>

                            <p style="color:#555;font-size:15px;">
                                Hello <strong>{{ $order->user->name ?? $order->name }}</strong>,
                            </p>

                            <p style="color:#555;font-size:15px;">
                                We have successfully received your order and it is now being processed.
                            </p>

                            <table width="100%" cellpadding="8" cellspacing="0"
                                style="margin:20px 0;background:#f8f9fa;border-radius:8px;">
                                <tr>
                                    <td><strong>Order Number:</strong></td>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Total Amount:</strong></td>
                                    <td>
                                        <strong style="color:#0d6efd;">
                                            {{ number_format($order->total, 2) }} EGP
                                        </strong>
                                    </td>
                                </tr>
                            </table>

                            <h3 style="margin-bottom:15px;color:#222;">
                                Order Items
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #e5e5e5;">

                                <thead>
                                    <tr style="background:#0d6efd;color:#fff;">
                                        <th align="left">Product</th>
                                        <th align="center">Quantity</th>
                                        <th align="right">Price</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr style="border-bottom:1px solid #eee;">
                                            <td>
                                                {{ $item->product?->name }}
                                            </td>

                                            <td align="center">
                                                {{ $item->quantity }}
                                            </td>

                                            <td align="right">
                                                {{ number_format($item->price, 2) }} EGP
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="margin-top:25px;padding:15px;background:#f8f9fa;border-radius:8px;">
                                <strong>Total:</strong>
                                <span style="float:right;color:#0d6efd;font-weight:bold;">
                                    {{ number_format($order->total, 2) }} EGP
                                </span>
                            </div>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px;text-align:center;background:#f8f9fa;color:#777;font-size:13px;">
                            Thank you for shopping with OneTech ♥
                            <br>
                            We appreciate your trust in us.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
    ```

</body>

</html>