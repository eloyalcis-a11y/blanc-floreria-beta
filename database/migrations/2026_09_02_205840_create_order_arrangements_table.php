<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_arrangements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('arrangement_type')->default('personalizado');
            $table->string('product_code')->nullable();
            $table->text('material')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('image_url')->nullable();
            $table->string('reference_image_path')->nullable();
            $table->text('notes')->nullable();
            $table->text('dedication_message')->nullable();
            $table->timestamps();
        });

        // Transfer data
        $orders = \DB::table('orders')->get();
        foreach ($orders as $order) {
            \DB::table('order_arrangements')->insert([
                'order_id' => $order->id,
                'arrangement_type' => $order->arrangement_type ?? 'personalizado',
                'product_code' => $order->product_code,
                'material' => $order->material,
                'quantity' => $order->quantity ?? 1,
                'image_url' => $order->image_url,
                'reference_image_path' => $order->reference_image_path,
                'notes' => $order->notes,
                'dedication_message' => $order->dedication_message,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        }

        // Drop columns from orders
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'arrangement_type',
                'product_code',
                'material',
                'quantity',
                'image_url',
                'reference_image_path',
                'notes',
                'dedication_message'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('arrangement_type')->default('personalizado');
            $table->string('product_code')->nullable();
            $table->text('material')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('image_url')->nullable();
            $table->string('reference_image_path')->nullable();
            $table->text('notes')->nullable();
            $table->text('dedication_message')->nullable();
        });

        // Restore data
        $arrangements = \DB::table('order_arrangements')->get();
        foreach ($arrangements as $arrangement) {
            // Just restore the first one if there are multiple
            \DB::table('orders')->where('id', $arrangement->order_id)->update([
                'arrangement_type' => $arrangement->arrangement_type,
                'product_code' => $arrangement->product_code,
                'material' => $arrangement->material,
                'quantity' => $arrangement->quantity,
                'image_url' => $arrangement->image_url,
                'reference_image_path' => $arrangement->reference_image_path,
                'notes' => $arrangement->notes,
                'dedication_message' => $arrangement->dedication_message,
            ]);
        }

        Schema::dropIfExists('order_arrangements');
    }
};
