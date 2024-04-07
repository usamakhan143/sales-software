<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoiceNumber');
            $table->string('combineDate');
            $table->bigInteger('day');
            $table->bigInteger('month');
            $table->bigInteger('year');
            $table->string('dueDate');
            $table->boolean('isDiscount')->default(false);
            $table->string('shippingCharges')->nullable();
            $table->boolean('isRecurring')->default(false);
            $table->string('recurringType')->nullable(); // Monthly, Weekly, Daily, Hourly
            $table->string('subTotal');
            $table->string('currentAmount');
            $table->string('totalAmount');
            $table->string('totalAmountDue')->nullable();
            $table->boolean('isEmailed')->default(false);
            $table->string('notes');
            $table->string('payLink')->nullable();
            $table->string('paymentStatus'); // Draft, Sent, Paid, Partially Paid, Overdue, Disputed, Void, Closed 
            $table->bigInteger('userId');
            $table->bigInteger('client_id');
            $table->bigInteger('brand_id');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
