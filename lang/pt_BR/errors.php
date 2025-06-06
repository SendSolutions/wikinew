<?php
/**
 * Text shown in error messaging.
 */
return [

    // Permissions
    'permission' => 'Você não tem permissão para acessar a página solicitada.',
    'permissionJson' => 'Você não tem permissão para realizar a ação solicitada.',

    // Auth
    'error_user_exists_different_creds' => 'Um usuário com o endereço eletrônico: endereço eletrônico já existe, mas com credenciais diferentes.',
    'auth_pre_register_theme_prevention' => 'A conta do usuário não pôde ser registrada com os detalhes oferecidos',
    'email_already_confirmed' => 'Endereço eletrônico já foi confirmado. Tente fazer o ‘login’.',
    'email_confirmation_invalid' => 'Esse código de confirmação não é válido ou já foi utilizado. Por favor, tente cadastrar-se novamente.',
    'email_confirmation_expired' => 'O código de confirmação já expirou. Uma nova mensagem eletrônica foi enviada.',
    'email_confirmation_awaiting' => 'O endereço do correio eletrônico da conta em uso precisa ser confirmado',
    'ldap_fail_anonymous' => 'O acesso LDAP falhou ao tentar usar o anonymous bind',
    'ldap_fail_authed' => 'O acesso LDAP falhou ao tentar os detalhes do dn e senha fornecidos',
    'ldap_extension_not_installed' => 'A extensão LDAP PHP não foi instalada',
    'ldap_cannot_connect' => 'Não foi possível conectar ao servidor LDAP. Conexão inicial falhou',
    'saml_already_logged_in' => '\'Login\' já efetuado',
    'saml_no_email_address' => 'Não foi possível encontrar um endereço de mensagem eletrônica para este usuário nos dados providos pelo sistema de autenticação externa',
    'saml_invalid_response_id' => 'A requisição do sistema de autenticação externa não foi reconhecida por um processo iniciado por esta aplicação. Após o \'login\', navegar para o caminho anterior pode causar um problema.',
    'saml_fail_authed' => 'Login utilizando :system falhou. Sistema não forneceu autorização bem sucedida',
    'oidc_already_logged_in' => '\'Login\' já efetuado',
    'oidc_no_email_address' => 'Não foi possível encontrar um endereço de mensagem eletrônica para este usuário, nos dados fornecidos pelo sistema de autenticação externa',
    'oidc_fail_authed' => 'Login usando :system falhou, o sistema não forneceu autorização com sucesso',
    'social_no_action_defined' => 'Nenhuma ação definida',
    'social_login_bad_response' => "Erro recebido durante o 'login' :socialAccount: \n: error",
    'social_account_in_use' => 'Essa conta :socialAccount já está em uso. Por favor, tente entrar utilizando a opção :socialAccount.',
    'social_account_email_in_use' => 'O e-mail :email já está em uso. Se você já tem uma conta você poderá se conectar a conta :socialAccount a partir das configurações de seu perfil.',
    'social_account_existing' => 'Essa conta :socialAccount já está vinculada a esse perfil.',
    'social_account_already_used_existing' => 'Essa conta :socialAccount já está sendo utilizada por outro usuário.',
    'social_account_not_used' => 'Essa conta :socialAccount não está vinculada a nenhum usuário. Por favor vincule a conta nas suas configurações de perfil. ',
    'social_account_register_instructions' => 'Se você não tem uma conta, você poderá se cadastrar usando a opção: conta social.',
    'social_driver_not_found' => 'Social driver não encontrado',
    'social_driver_not_configured' => 'Seus parâmetros sociais de: conta social não estão configurados corretamente.',
    'invite_token_expired' => 'Este link de convite expirou. Alternativamente, você pode tentar redefinir a senha da sua conta.',
    'login_user_not_found' => 'Não foi possível encontrar um usuário para esta ação.',

    // System
    'path_not_writable' => 'O caminho de destino (:filePath) de upload de arquivo não possui permissão de escrita. Certifique-se que ele possui direitos de escrita no servidor.',
    'cannot_get_image_from_url' => 'Não foi possível obter a imagem a partir de :url',
    'cannot_create_thumbs' => 'O servidor não pôde criar as miniaturas de imagem. Por favor, verifique se a extensão GD PHP está instalada.',
    'server_upload_limit' => 'O servidor não permite o ‘upload’ de arquivos com esse tamanho. Por favor, tente um tamanho de arquivo menor.',
    'server_post_limit' => 'O servidor não pode receber a quantidade de dados fornecida. Tente novamente com menos dados ou um arquivo menor.',
    'uploaded'  => 'O servidor não permite o ‘upload’ de arquivos com esse tamanho. Por favor, tente fazer o ‘upload’ de arquivos de menor tamanho.',

    // Drawing & Images
    'image_upload_error' => 'Um erro ocorreu enquanto o servidor tentava efetuar o ‘upload’ da imagem',
    'image_upload_type_error' => 'A categoria de imagem que está sendo enviada é inválida',
    'image_upload_replace_type' => 'As substituições de arquivos de imagem devem ser do mesmo tipo',
    'image_upload_memory_limit' => 'Falha ao processar o ‘upload’ de imagem e/ou criar miniaturas devido a limites de recursos do sistema.',
    'image_thumbnail_memory_limit' => 'Falha ao criar variações de tamanho de imagem devido a limites de recursos do sistema.',
    'image_gallery_thumbnail_memory_limit' => 'Falha ao criar miniaturas da galeria devido aos limites de recursos do sistema.',
    'drawing_data_not_found' => 'Dados de desenho não puderam ser carregados. O arquivo de desenho pode não existir mais ou você não tenha permissão para acessá-lo.',

    // Attachments
    'attachment_not_found' => 'Documento não encontrado',
    'attachment_upload_error' => 'Um erro ocorreu ao efetuar o ‘upload’ do arquivo anexado',

    // Pages
    'page_draft_autosave_fail' => 'Falha ao tentar salvar o rascunho. Certifique-se de ter conexão de ‘internet’ antes de tentar salvar essa página',
    'page_draft_delete_fail' => 'Falha ao excluir o rascunho da página e buscar conteúdo salvo na página atual',
    'page_custom_home_deletion' => 'Não é possível deletar uma página definida como página inicial',

    // Entities
    'entity_not_found' => 'Entidade não encontrada
',
    'bookshelf_not_found' => 'Sistema não encontrada',
    'book_not_found' => 'Módulo não encontrado',
    'page_not_found' => 'Página não encontrada',
    'chapter_not_found' => 'Release não encontrado',
    'selected_book_not_found' => 'O Módulo selecionado não foi encontrado',
    'selected_book_chapter_not_found' => 'O Módulo ou Release selecionado não foi encontrado',
    'guests_cannot_save_drafts' => 'Convidados não podem salvar rascunhos',

    // Users
    'users_cannot_delete_only_admin' => 'Você não pode excluir o único administrador',
    'users_cannot_delete_guest' => 'Você não pode excluir o usuário convidado',
    'users_could_not_send_invite' => 'Não foi possível criar o usuário porque o endereço eletrônico de convite não foi enviado',

    // Roles
    'role_cannot_be_edited' => 'Esse perfil não pode ser editado',
    'role_system_cannot_be_deleted' => 'Este é um perfil do sistema e não pode ser excluído',
    'role_registration_default_cannot_delete' => 'Esse perfil não poderá se excluído enquanto estiver registrado como perfil padrão de registro',
    'role_cannot_remove_only_admin' => 'Este usuário é o único vinculado ao perfil de administrador. Atribua o perfil de administrador a outro usuário antes de tentar removê-lo daqui.',

    // Comments
    'comment_list' => 'Ocorreu um erro ao buscar os comentários.',
    'cannot_add_comment_to_draft' => 'Você não pode adicionar comentários a um rascunho.',
    'comment_add' => 'Ocorreu um erro ao adicionar / atualizar o comentário.',
    'comment_delete' => 'Ocorreu um erro ao excluir o comentário.',
    'empty_comment' => 'Não é possível adicionar um comentário vazio.',

    // Error pages
    '404_page_not_found' => 'Página Não Encontrada',
    'sorry_page_not_found' => 'Desculpe, a página que você está procurando não pôde ser encontrada.',
    'sorry_page_not_found_permission_warning' => 'Se você esperava que esta página existisse, talvez você não tenha permissão para visualizá-la.',
    'image_not_found' => 'Imagem não encontrada',
    'image_not_found_subtitle' => 'Desculpe, o arquivo de imagem que você estava procurando não pôde ser encontrado.',
    'image_not_found_details' => 'Se você esperava que esta imagem existisse, ela pode ter sido excluída.',
    'return_home' => 'Retornar à página inicial',
    'error_occurred' => 'Ocorreu um Erro',
    'app_down' => ':appName está fora do ar no momento',
    'back_soon' => 'Vai estar de volta em breve.',

    // Import
    'import_zip_cant_read' => 'Não foi possível ler o arquivo ZIP.',
    'import_zip_cant_decode_data' => 'Não foi possível encontrar e decodificar o conteúdo ZIP data.json.',
    'import_zip_no_data' => 'Os dados do arquivo ZIP não têm o conteúdo esperado Módulo, Release ou página.',
    'import_validation_failed' => 'Falhou na validação da importação do ZIP com erros:',
    'import_zip_failed_notification' => 'Falhou ao importar arquivo ZIP.',
    'import_perms_books' => 'Você não tem as permissões necessárias para criar Módulos.',
    'import_perms_chapters' => 'Você não tem as permissões necessárias para criar Releases.',
    'import_perms_pages' => 'Você não tem as permissões necessárias para criar páginas.',
    'import_perms_images' => 'Está não tem permissões necessárias para criar imagens.',
    'import_perms_attachments' => 'Você não tem a permissão necessária para criar anexos.',

    // API errors
    'api_no_authorization_found' => 'Nenhum código de autorização encontrado na requisição',
    'api_bad_authorization_format' => 'Um código de autorização foi encontrado na requisição, mas o formato parece incorreto',
    'api_user_token_not_found' => 'Nenhum código de API correspondente foi encontrado para o código de autorização fornecido',
    'api_incorrect_token_secret' => 'O segredo fornecido para o código de API usado está incorreto',
    'api_user_no_api_permission' => 'O proprietário do código de API utilizado não tem permissão para fazer requisições de API',
    'api_user_token_expired' => 'O código de autenticação expirou',

    // Settings & Maintenance
    'maintenance_test_email_failure' => 'Erro encontrado ao enviar uma mensagem eletrônica de teste:',

    // HTTP errors
    'http_ssr_url_no_match' => 'A \'URL\' não corresponde aos anfitriões SSR configurados como permitidos ',
];
