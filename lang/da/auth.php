<?php
/**
 * Authentication Language Lines
 * The following language lines are used during authentication for various
 * messages that we need to display to the user.
 */
return [

    'failed' => 'Dee indtastede brugeroplysninger stemmer ikke overens med vores registreringer.',
    'throttle' => 'For mange mislykkede loginforsøg. Prøv igen om :seconds sekunder.',

    // Login & Register
    'sign_up' => 'Registrér',
    'log_in' => 'Log ind',
    'log_in_with' => 'Log ind med :socialDriver',
    'sign_up_with' => 'Registrér med :socialDriver',
    'logout' => 'Log ud',

    'name' => 'Navn',
    'username' => 'Brugernavn',
    'email' => 'E-mail',
    'password' => 'Adgangskode',
    'password_confirm' => 'Bekræft adgangskode',
    'password_hint' => 'Skal være på mindst 8 karakterer',
    'forgot_password' => 'Glemt Adgangskode?',
    'remember_me' => 'Husk mig',
    'ldap_email_hint' => 'Angiv venligst din kontos e-mail.',
    'create_account' => 'Opret konto',
    'already_have_account' => 'Har du allerede en konto?',
    'dont_have_account' => 'Har du ikke en konto?',
    'social_login' => 'Social Log ind',
    'social_registration' => 'Social Registrering',
    'social_registration_text' => 'Registrér og log ind med anden service.',

    'register_thanks' => 'Tak for registreringen!',
    'register_confirm' => 'Check venligst din e-mail og klik deri på bekræftelses knappen for at tilgå :appName.',
    'registrations_disabled' => 'Registrering er i øjeblikket deaktiveret',
    'registration_email_domain_invalid' => 'E-Mail domænet har ikke adgang til denne applikation',
    'register_success' => 'Tak for din registrering. Du er nu registeret og logget ind.',

    // Login auto-initiation
    'auto_init_starting' => 'Forsøger Login',
    'auto_init_starting_desc' => 'Vi kontakter dit godkendelsessystem for at starte loginprocessen. Hvis der ikke er nogen fremskridt efter 5 sekunder, kan du prøve at klikke på linket nedenfor.',
    'auto_init_start_link' => 'Fortsæt med godkendelse',

    // Password Reset
    'reset_password' => 'Nulstil adgangskode',
    'reset_password_send_instructions' => 'Indtast din E-Mail herunder og du vil blive sendt en E-Mail med et link til at nulstille din adgangskode.',
    'reset_password_send_button' => 'Send link til nulstilling',
    'reset_password_sent' => 'Et link til nulstilling af adgangskode sendes til :email, hvis den e-mail-adresse findes i systemet.',
    'reset_password_success' => 'Din adgangskode er blevet nulstillet.',
    'email_reset_subject' => 'Nulstil din :appName adgangskode',
    'email_reset_text' => 'Du modtager denne E-Mail fordi vi har modtaget en anmodning om at nulstille din adgangskode.',
    'email_reset_not_requested' => 'Hvis du ikke har anmodet om at få din adgangskode nulstillet, behøver du ikke at foretage dig noget.',

    // Email Confirmation
    'email_confirm_subject' => 'Bekræft din E-Mail på :appName',
    'email_confirm_greeting' => 'Tak for at oprette dig på :appName!',
    'email_confirm_text' => 'Bekræft venligst din E-Mail adresse ved at klikke på linket nedenfor:',
    'email_confirm_action' => 'Bekræft E-Mail',
    'email_confirm_send_error' => 'E-Mail-bekræftelse kræves, men systemet kunne ikke sende E-Mailen. Kontakt administratoren for at sikre, at E-Mail er konfigureret korrekt.',
    'email_confirm_success' => 'Din email er blevet bekræftet! Du bør nu kune logge ind med denne emailadresse.',
    'email_confirm_resent' => 'Bekræftelsesmail sendt, tjek venligst din indboks.',
    'email_confirm_thanks' => 'Tak for bekræftelsen!',
    'email_confirm_thanks_desc' => 'Vent venligst et øjeblik, mens din bekræftelse behandles. Hvis du ikke bliver omdirigeret efter 3 sekunder, skal du trykke på linket "Fortsæt" nedenfor for at fortsætte.',

    'email_not_confirmed' => 'E-Mail adresse ikke bekræftet',
    'email_not_confirmed_text' => 'Din E-Mail adresse er endnu ikke blevet bekræftet.',
    'email_not_confirmed_click_link' => 'Klik venligst på linket i E-Mailen der blev sendt kort efter du registrerede dig.',
    'email_not_confirmed_resend' => 'Hvis du ikke kan finde E-Mailen, kan du du få gensendt bekræftelsesemailen ved at trykke herunder.',
    'email_not_confirmed_resend_button' => 'Gensend bekræftelsesemail',

    // User Invite
    'user_invite_email_subject' => 'Du er blevet inviteret til :appName!',
    'user_invite_email_greeting' => 'En konto er blevet oprettet til dig på :appName.',
    'user_invite_email_text' => 'Klik på knappen nedenunderm for at sætte en adgangskode og opnå adgang:',
    'user_invite_email_action' => 'Set adgangskode',
    'user_invite_page_welcome' => 'Velkommen til :appName!',
    'user_invite_page_text' => 'For at færdiggøre din konto og få adgang skal du indstille en adgangskode, der bruges til at logge ind på :appName ved fremtidige besøg.',
    'user_invite_page_confirm_button' => 'Bekræft adgangskode',
    'user_invite_success_login' => 'Adgangskoden er sat. Du burde nu kunne logge ind med din angivede adgangskode for at tilgå :appName!',

    // Multi-factor Authentication
    'mfa_setup' => 'Opsætning af Multi-faktor godkendelse',
    'mfa_setup_desc' => 'Opsæt multi-faktor godkendelse som et ekstra lag af sikkerhed for din brugerkonto.',
    'mfa_setup_configured' => 'Allerede konfigureret',
    'mfa_setup_reconfigure' => 'Genkonfigurer',
    'mfa_setup_remove_confirmation' => 'Er du sikker på, at du vil fjerne denne multi-faktor godkendelsesmetode?',
    'mfa_setup_action' => 'Opsætning',
    'mfa_backup_codes_usage_limit_warning' => 'Du har mindre end 5 backup koder tilbage, generere og gem et nyt sæt før du løber tør for koder, for at forhindre at blive lukket ude af din konto.',
    'mfa_option_totp_title' => 'Mobil app',
    'mfa_option_totp_desc' => 'For at bruge multi-faktor godkendelse, skal du bruge en mobil app, der understøtter TOTP såsom Google Authenticator, Authy eller Microsoft Authenticator.',
    'mfa_option_backup_codes_title' => 'Backup koder',
    'mfa_option_backup_codes_desc' => 'Genererer et sæt backup-koder til engangsbrug, som du skal indtaste ved login for at bekræfte din identitet. Sørg for at opbevare dem et sikkert sted.',
    'mfa_gen_confirm_and_enable' => 'Bekræft og aktivér',
    'mfa_gen_backup_codes_title' => 'Backup koder opsætning',
    'mfa_gen_backup_codes_desc' => 'Opbevar nedenstående liste med koder et sikkert sted. Når du får adgang til systemet, kan du bruge en af koderne som en ekstra godkendelsesmekanisme.',
    'mfa_gen_backup_codes_download' => 'Download koder',
    'mfa_gen_backup_codes_usage_warning' => 'Hver kode kan kun bruges en gang',
    'mfa_gen_totp_title' => 'Mobil App Setup',
    'mfa_gen_totp_desc' => 'For at bruge multifaktorgodkendelse skal du bruge en mobilapplikation, der understøtter TOTP, f.eks. Google Authenticator, Authy eller Microsoft Authenticator.',
    'mfa_gen_totp_scan' => 'Scan QR-koden nedenfor med din foretrukne godkendelsesapp for at komme i gang.',
    'mfa_gen_totp_verify_setup' => 'Verificer Opsætning',
    'mfa_gen_totp_verify_setup_desc' => 'Kontrollér, at alt fungerer, ved at indtaste en kode, der er genereret i din godkendelsesapp, i indtastningsfeltet nedenfor:',
    'mfa_gen_totp_provide_code_here' => 'Angiv din app-genererede kode her',
    'mfa_verify_access' => 'Bekræft Adgang',
    'mfa_verify_access_desc' => 'Din brugerkonto kræver, at du bekræfter din identitet via et ekstra verifikationsniveau, før du får adgang. Bekræft ved hjælp af en af dine konfigurerede metoder for at fortsætte.',
    'mfa_verify_no_methods' => 'Ingen Metoder Konfigureret',
    'mfa_verify_no_methods_desc' => 'Der blev ikke fundet nogen metoder til multifaktorgodkendelse til din konto. Du skal konfigurere mindst én metode, før du får adgang.',
    'mfa_verify_use_totp' => 'Bekræft ved brug af en mobil app',
    'mfa_verify_use_backup_codes' => 'Bekræft ved hjælp af en backup kode',
    'mfa_verify_backup_code' => 'Backup Kode',
    'mfa_verify_backup_code_desc' => 'Indtast en af dine resterende backup koder nedenfor:',
    'mfa_verify_backup_code_enter_here' => 'Indtast backup kode her',
    'mfa_verify_totp_desc' => 'Indtast koden, der er genereret med din mobilapp, nedenfor:',
    'mfa_setup_login_notification' => 'Multifaktormetode konfigureret, log venligst ind igen med den konfigurerede metode.',
];
