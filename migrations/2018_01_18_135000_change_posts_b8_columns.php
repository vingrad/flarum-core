<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('posts', function (Blueprint $table) {
            $table->renameColumn('time', 'created_at');
            $table->renameColumn('edit_time', 'edited_at');
            $table->renameColumn('hide_time', 'hidden_at');

            $table->renameColumn('edit_user_id', 'edited_user_id');
            $table->renameColumn('hide_user_id', 'hidden_user_id');

            $table->longText('content')->change();

            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('edited_user_id')->references('id')->on('users');
            $table->foreign('hidden_user_id')->references('id')->on('users');
        });
    },

    'down' => function (Builder $schema) {
        $schema->table('posts', function (Blueprint $table) {
            $table->renameColumn('created_at', 'time');
            $table->renameColumn('edited_at', 'edit_time');
            $table->renameColumn('hidden_at', 'hide_time');

            $table->renameColumn('edited_user_id', 'edit_user_id');
            $table->renameColumn('edited_user_id', 'hidden_user_id');

            $table->mediumText('content')->change();

            $table->dropForeign([
                'posts_user_id_foreign', 'posts_discussion_id_foreign',
                'posts_edited_user_id_foreign', 'posts_hidden_user_id_foreign'
            ]);
        });
    }
];