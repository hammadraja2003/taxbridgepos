<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $col) {
            $col->id();
            $col->string('title');
            $col->unsignedBigInteger('bus_config_id');
            $col->enum('priority', ['informational', 'new_feature', 'medium', 'critical']);
            $col->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            $col->text('description');
            $col->unsignedBigInteger('created_by');
            $col->timestamps();

            $col->foreign('bus_config_id')->references('bus_config_id')->on('business_configurations')->onDelete('cascade');
        });

        Schema::create('ticket_comments', function (Blueprint $col) {
            $col->id();
            $col->unsignedBigInteger('ticket_id');
            $col->text('comment');
            $col->unsignedBigInteger('commenter_id');
            $col->string('commenter_type');
            $col->timestamps();

            $col->foreign('ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });

        Schema::create('ticket_attachments', function (Blueprint $col) {
            $col->id();
            $col->unsignedBigInteger('ticket_id');
            $col->string('file_path');
            $col->string('file_name');
            $col->string('file_type');
            $col->timestamps();

            $col->foreign('ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });

        Schema::create('ticket_histories', function (Blueprint $col) {
            $col->id();
            $col->unsignedBigInteger('ticket_id');
            $col->string('action');
            $col->unsignedBigInteger('performer_id');
            $col->string('performer_type');
            $col->timestamps();

            $col->foreign('ticket_id')->references('id')->on('support_tickets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_histories');
        Schema::dropIfExists('ticket_attachments');
        Schema::dropIfExists('ticket_comments');
        Schema::dropIfExists('support_tickets');
    }
};
