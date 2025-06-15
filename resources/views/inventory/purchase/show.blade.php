@extends('layouts.master')

@section('title', 'Ver Orden de Compra')
@section('subtitle', 'Detalles de la orden #' . $purchase->id)

@section('content')
    <div class="row">
        {{-- Panel de Detalles Principales --}}
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Orden de Compra #{{ $purchase->id }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Proveedor</dt>
                        {{-- CORRECCIÓN: Usamos ?? para el caso de que el proveedor sea nulo --}}
                        <dd class="col-sm-9">{{ $purchase->supplier->name ?? 'PROVEEDOR NO ENCONTRADO' }}</dd>

                        <dt class="col-sm-3">Estado</dt>
                        <dd class="col-sm-9"><span class="badge badge-info">{{ ucfirst($purchase->status) }}</span>
                        </dd>

                        <dt class="col-sm-3">Total</dt>
                        <dd class="col-sm-9">S/ {{ number_format($purchase->total, 2) }}</dd>

                        <dt class="col-sm-3">Creado por</dt>
                        {{-- CORRECCIÓN: Usamos ?? por seguridad --}}
                        <dd class="col-sm-9">{{ $purchase->user->name ?? 'Usuario no encontrado' }} el
                            {{ $purchase->created_at?->format('d/m/Y') }}</dd>

                        {{-- El @if ya protege esta parte, pero añadimos ?? por si acaso --}}
                        @if ($purchase->approver)
                            <dt class="col-sm-3">Aprobado por</dt>
                            <dd class="col-sm-9">{{ $purchase->approver->name ?? 'N/A' }} el
                                {{-- También protegemos la fecha, por si es nula --}}
                                {{ $purchase->approved_at?->format('d/m/Y') }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Panel de Productos Pedidos --}}
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Productos Pedidos</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->details as $detail)
                                <tr>
                                    {{-- CORRECCIÓN: Usamos ?? por si el producto fue borrado --}}
                                    <td>{{ $detail->product->name ?? 'PRODUCTO NO ENCONTRADO' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>S/ {{ number_format($detail->unit_price, 2) }}</td>
                                    <td>S/ {{ number_format($detail->quantity * $detail->unit_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE ACCIONES CONDICIONALES --}}

    {{-- Si la orden está PENDIENTE y eres SUPERVISOR, puedes aprobarla --}}
    @if ($purchase->status == 'pending' && auth()->user()->role == 'supervisor')
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Acciones de Aprobación</h4>
            </div>
            <div class="card-body">
                {{-- CORRECCIÓN: Nombre de la ruta estandarizado --}}
                <form action="{{ route('purchases.approve', $purchase) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Aprobar Orden de
                        Compra</button>
                </form>
            </div>
        </div>
    @endif

    {{-- Si la orden está APROBADA y eres de ALMACÉN o SUPERVISOR, puedes registrar la recepción --}}
    @if ($purchase->status == 'approved' && in_array(auth()->user()->role, ['supervisor', 'warehouse']))
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Registrar Recepción de Mercadería</h4>
            </div>
            <div class="card-body">
                {{-- CORRECCIÓN: Nombre de la ruta estandarizado --}}
                <form action="{{ route('purchases.receive', $purchase) }}" method="POST">
                    <form action="{{ route('purchases.receive', $purchase) }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cant. Pedida</th>
                                        <th class="text-center">Cant. Recibida</th>
                                        <th>Lote</th>
                                        <th>F. Vencimiento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->details as $detail)
                                        <tr>
                                            {{-- Input oculto para enviar el ID del producto --}}
                                            <input type="hidden" name="details[{{ $loop->index }}][product_id]"
                                                value="{{ $detail->product_id }}">

                                            <td>{{ $detail->product->name ?? 'PRODUCTO NO ENCONTRADO' }}</td>
                                            <td class="text-center">{{ $detail->quantity }}</td>
                                            <td>
                                                <input type="number" name="details[{{ $loop->index }}][quantity]"
                                                    class="form-control" value="{{ $detail->quantity }}"
                                                    max="{{ $detail->quantity }}" min="0" required>
                                            </td>
                                            <td>
                                                <input type="text" name="details[{{ $loop->index }}][batch]"
                                                    class="form-control">
                                            </td>
                                            <td>
                                                <input type="date" name="details[{{ $loop->index }}][expiration_date]"
                                                    class="form-control">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-truck-loading"></i> Confirmar y
                            Registrar Ingreso</button>
                    </form>
                </form>
            </div>
        </div>
    @endif

    {{-- CORRECCIÓN: Nombre de la ruta estandarizado --}}
    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al
        Listado</a>
@endsection
