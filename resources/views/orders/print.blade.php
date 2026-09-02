<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden {{ $order->order_number }}</title>
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
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #4A1525;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
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
            gap: 15px;
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
            <p><strong>Detalle de Orden:</strong> {{ $order->order_number }}</p>
            <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="grid">
            <!-- Columna Izquierda -->
            <div>
                <div class="section">
                    <div class="section-title">Información del Cliente</div>
                    <div class="field"><span class="label">Cliente:</span> <span class="value">{{ $order->client_name }}</span></div>
                    <div class="field"><span class="label">Teléfono:</span> <span class="value">{{ $order->client_phone ?? 'N/E' }}</span></div>
                    <div class="field"><span class="label">Quién recibe:</span> <span class="value">{{ $order->recipient_name ?? 'N/E' }}</span></div>
                    <div class="field"><span class="label">Quién envía:</span> <span class="value">{{ $order->sender_name ?? 'N/E' }}</span></div>
                </div>

                <div class="section">
                    <div class="section-title">Logística y Entrega</div>
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

            <!-- Columna Derecha -->
            <div>
                <div class="section">
                    <div class="section-title">Detalles del Arreglo</div>
                    <div class="field"><span class="label">Modelo/Material:</span> <span class="value">{{ $order->material }}</span></div>
                    <div class="field"><span class="label">Cantidad:</span> <span class="value">{{ $order->quantity }}</span></div>
                    <div class="field"><span class="label">Tipo:</span> <span class="value" style="text-transform: capitalize;">{{ $order->arrangement_type }}</span></div>
                    
                    @if($order->notes)
                    <div class="field full-width" style="margin-top: 10px;">
                        <span class="label">Notas Especiales:</span>
                        <div class="value" style="margin-top: 5px; color: #c0392b; font-weight: bold;">{{ $order->notes }}</div>
                    </div>
                    @endif
                </div>
                
                <div class="section">
                    <div class="section-title">Mensaje de la Tarjeta</div>
                    @if($order->dedication_message)
                        <div class="message-box">
                            {!! nl2br(e($order->dedication_message)) !!}
                        </div>
                    @else
                        <p style="color: #999; font-style: italic;">Sin mensaje de dedicatoria.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            Generado automáticamente por el Sistema de Gestión de Blanc Florería - {{ date('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
