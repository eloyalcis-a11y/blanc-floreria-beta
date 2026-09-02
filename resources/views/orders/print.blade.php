<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acuse de Pedido {{ $order->order_number }}</title>
    <style>
        @page {
            size: auto;
            margin: 10mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4A1525;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #4A1525;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 16px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-weight: bold;
            font-size: 16px;
            color: #4A1525;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .field {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 140px;
        }
        .value {
            color: #000;
        }
        .full-width {
            grid-column: span 2;
        }
        .message-box {
            border: 1px dashed #ccc;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            font-style: italic;
            margin-top: 10px;
        }
        .arrangement-block {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fafafa;
            page-break-inside: avoid;
        }
        .arrangement-title {
            font-weight: bold;
            color: #4A1525;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .container {
                width: 100%;
                max-width: none;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4A1525; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
            🖨️ Imprimir
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #eee; color: #333; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Cerrar
        </button>
    </div>

    <div class="container">
        <div class="header">
            <h1>Blanc Florería</h1>
            <p><strong>Acuse de Pedido:</strong> {{ $order->order_number }}</p>
            <p><strong>Fecha de Registro:</strong> {{ $order->created_at->timezone('America/Mexico_City')->format('d/m/Y h:i A') }}</p>
        </div>

        <div class="grid">
            <!-- Columna Izquierda -->
            <div>
                <div class="section">
                    <div class="section-title">Detalles de Entrega</div>
                    <div class="field"><span class="label">Quién recibe:</span> <span class="value">{{ $order->recipient_name ?? 'N/E' }}</span></div>
                    <div class="field"><span class="label">Quién envía:</span> <span class="value">{{ $order->sender_name ?? 'Anónimo' }}</span></div>
                </div>

                <div class="section">
                    <div class="section-title">Logística</div>
                    <div class="field"><span class="label">Fecha de Entrega:</span> <span class="value">{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') : 'N/E' }}</span></div>
                    <div class="field"><span class="label">Horario:</span> <span class="value">{{ $order->delivery_time ?? 'N/E' }}</span></div>
                    <div class="field"><span class="label">Dirección:</span> <span class="value">{{ $order->delivery_street }} {{ $order->delivery_neighborhood }} {{ $order->delivery_zip }}</span></div>
                    <div class="field full-width">
                        <span class="label">Referencias:</span> 
                        <div class="value" style="margin-top: 5px;">{{ $order->delivery_references ?? 'N/E' }}</div>
                    </div>
                    @if($order->delivery_reference_image_path)
                    <div class="field full-width" style="margin-top: 10px;">
                        <span class="label">Foto de fachada:</span> 
                        <div style="margin-top: 5px;">
                            <img src="{{ asset($order->delivery_reference_image_path) }}" alt="Fachada" style="max-width: 200px; max-height: 150px; border: 1px solid #ccc; border-radius: 4px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Columna Derecha: Arreglos -->
            <div>
                <div class="section">
                    <div class="section-title">Arreglos ({{ $order->arrangements->count() }})</div>
                    
                    @foreach($order->arrangements as $index => $arr)
                    <div class="arrangement-block">
                        <div class="arrangement-title">Arreglo #{{ $index + 1 }}</div>
                        <div class="field"><span class="label" style="width:100px;">Descripción:</span> <span class="value">{{ $arr->material }}</span></div>
                        <div class="field"><span class="label" style="width:100px;">Cantidad:</span> <span class="value">{{ $arr->quantity }}</span></div>
                        <div class="field"><span class="label" style="width:100px;">Tipo:</span> <span class="value" style="text-transform: capitalize;">{{ $arr->arrangement_type }}</span></div>
                        
                        @if($arr->image_url)
                        <div class="field full-width" style="margin-top: 10px; margin-bottom: 10px;">
                            <span class="label">Referencia visual:</span>
                            <div style="margin-top: 5px;">
                                <img src="{{ Str::startsWith($arr->image_url, 'http') ? $arr->image_url : asset($arr->image_url) }}" alt="Referencia" style="max-width: 100%; max-height: 250px; border: 1px solid #ccc; border-radius: 8px; object-fit: contain;">
                            </div>
                        </div>
                        @endif
                        
                        @if($arr->notes)
                        <div class="field full-width" style="margin-top: 5px;">
                            <span class="label">Notas Especiales:</span>
                            <div class="value" style="margin-top: 2px; color: #c0392b; font-weight: bold;">{{ $arr->notes }}</div>
                        </div>
                        @endif
                        
                        @if($arr->dedication_message)
                        <div class="field full-width" style="margin-top: 10px;">
                            <span class="label">Mensaje en Tarjeta:</span>
                            <div class="message-box">
                                {!! nl2br(e($arr->dedication_message)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="footer">
            Generado automáticamente por el Sistema de Gestión de Blanc Florería - {{ \Carbon\Carbon::now()->timezone('America/Mexico_City')->format('d/m/Y h:i A') }}
        </div>
    </div>
</body>
</html>
