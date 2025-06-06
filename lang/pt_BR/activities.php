<?php
/**
 * Activity text strings.
 * Is used for all the text within activity logs & notifications.
 */
return [

    // Pages
    'page_create'                 => 'criou a página',
    'page_create_notification'    => 'Página criada com sucesso',
    'page_update'                 => 'atualizou a página',
    'page_update_notification'    => 'Página atualizada com sucesso',
    'page_delete'                 => 'excluiu a página',
    'page_delete_notification'    => 'Página excluída com sucesso',
    'page_restore'                => 'restaurou a página',
    'page_restore_notification'   => 'Página restaurada com sucesso',
    'page_move'                   => 'moveu a página',
    'page_move_notification'      => 'Página movida com sucesso',

    // Chapters
    'chapter_create'              => 'criou o Release',
    'chapter_create_notification' => 'Release criado com sucesso',
    'chapter_update'              => 'atualizou o Release',
    'chapter_update_notification' => 'Release atualizado com sucesso',
    'chapter_delete'              => 'excluiu o Release',
    'chapter_delete_notification' => 'Release excluída com sucesso',
    'chapter_move'                => 'moveu o Release',
    'chapter_move_notification' => 'Release excluído com sucesso',

    // Books
    'book_create'                 => 'criou o Módulo',
    'book_create_notification'    => 'Módulo criado com sucesso',
    'book_create_from_chapter'              => 'Release convertido em Módulo',
    'book_create_from_chapter_notification' => 'Release convertido em Módulo com sucesso',
    'book_update'                 => 'atualizou o Módulo',
    'book_update_notification'    => 'Módulo atualizado com sucesso',
    'book_delete'                 => 'excluiu o Módulo',
    'book_delete_notification'    => 'Módulo excluído com sucesso',
    'book_sort'                   => 'ordenou o Módulo',
    'book_sort_notification'      => 'Módulo reordenado com sucesso',

    // Bookshelves
    'bookshelf_create'            => 'Sistema criada',
    'bookshelf_create_notification'    => 'Sistema criada com sucesso',
    'bookshelf_create_from_book'    => 'Módulo convertido em Sistema',
    'bookshelf_create_from_book_notification'    => 'Módulo convertido com sucesso em uma Sistema',
    'bookshelf_update'                 => 'Sistema atualizada',
    'bookshelf_update_notification'    => 'Sistema atualizada com sucesso',
    'bookshelf_delete'                 => 'Sistema excluída',
    'bookshelf_delete_notification'    => 'Sistema excluída com sucesso',

    // Revisions
    'revision_restore' => 'revisão restaurada',
    'revision_delete' => 'revisão excluída',
    'revision_delete_notification' => 'Revisão excluída com sucesso',

    // Favourites
    'favourite_add_notification' => '":name" foi adicionada aos seus favoritos',
    'favourite_remove_notification' => '":name" foi removida dos seus favoritos',

    // Watching
    'watch_update_level_notification' => 'Preferências de Observação atualizadas com sucesso',

    // Auth
    'auth_login' => 'conectado',
    'auth_register' => 'registrado como novo usuário',
    'auth_password_reset_request' => 'redefinir senha do usuário solicitado',
    'auth_password_reset_update' => 'redefinir senha do usuário',
    'mfa_setup_method' => 'método MFA configurado',
    'mfa_setup_method_notification' => 'Método de multi-fatores configurado com sucesso',
    'mfa_remove_method' => 'Método MFA removido',
    'mfa_remove_method_notification' => 'Método de multi-fatores removido com sucesso',

    // Settings
    'settings_update' => 'configurações atualizadas',
    'settings_update_notification' => 'Configurações atualizadas com sucesso',
    'maintenance_action_run' => 'Ação de manutenção executada',

    // Webhooks
    'webhook_create' => 'webhook criado',
    'webhook_create_notification' => 'Webhook criado com sucesso',
    'webhook_update' => 'webhook atualizado',
    'webhook_update_notification' => 'Webhook atualizado com sucesso',
    'webhook_delete' => 'webhook excluído',
    'webhook_delete_notification' => 'Webhook excluido com sucesso',

    // Imports
    'import_create' => 'importação criada',
    'import_create_notification' => 'Importação carregada com sucesso',
    'import_run' => 'importação atualizada',
    'import_run_notification' => 'Conteúdo importado com sucesso',
    'import_delete' => 'importação excluída',
    'import_delete_notification' => 'Importação excluída com sucesso',

    // Users
    'user_create' => 'usuário criado',
    'user_create_notification' => 'Usuário criado com sucesso',
    'user_update' => 'usuário atualizado',
    'user_update_notification' => 'Usuário atualizado com sucesso',
    'user_delete' => 'usuário excluído',
    'user_delete_notification' => 'Usuário removido com sucesso',

    // API Tokens
    'api_token_create' => 'token de API criado',
    'api_token_create_notification' => 'Token de API criado com sucesso',
    'api_token_update' => 'token de API atualizado',
    'api_token_update_notification' => 'Token de API atualizado com sucesso',
    'api_token_delete' => 'token de API excluído',
    'api_token_delete_notification' => 'Token de API excluído com sucesso',

    // Roles
    'role_create' => 'perfil criado',
    'role_create_notification' => 'Perfil criado com sucesso',
    'role_update' => 'perfil atualizado',
    'role_update_notification' => 'Perfil atualizado com sucesso',
    'role_delete' => 'Excluir papel',
    'role_delete_notification' => 'Perfil excluído com sucesso',

    // Recycle Bin
    'recycle_bin_empty' => 'lixeira esvaziada',
    'recycle_bin_restore' => 'restaurado da lixeira',
    'recycle_bin_destroy' => 'removido da lixeira',

    // Comments
    'commented_on'                => 'comentou em',
    'comment_create'              => 'Adicionou comentário',
    'comment_update'              => 'Atualizar descrição',
    'comment_delete'              => 'Comentário deletado',

    // Sort Rules
    'sort_rule_create' => 'regra de classificação criada',
    'sort_rule_create_notification' => 'Regra de classificação criada com sucesso',
    'sort_rule_update' => 'regra de classificação atualizada',
    'sort_rule_update_notification' => 'Sort rule successfully updated',
    'sort_rule_delete' => 'regra de classificação excluída',
    'sort_rule_delete_notification' => 'Regra de classificação excluída com sucesso',

    // Other
    'permissions_update'          => 'atualizou permissões',
];
