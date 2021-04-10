-- NÃO DEIXOU USAR BOOLEAN
CREATE TABLE alternativa (
    id int PRIMARY KEY IDENTITY,
    questao_id integer NOT NULL,
    descricao text NOT NULL,
    is_correta char DEFAULT 0 NOT NULL
);

CREATE TABLE alternativa_resposta_questao (
    id int PRIMARY KEY IDENTITY,
    alternativa_id integer NOT NULL,
    questao_usuario_prova_id integer NOT NULL
);

CREATE TABLE grupo (
    id int PRIMARY KEY IDENTITY,
    nome text NOT NULL,
    descricao text NOT NULL
);

CREATE TABLE grupo_prova (
    id int PRIMARY KEY IDENTITY,
    prova_id integer NOT NULL,
    grupo_id integer NOT NULL
);

CREATE TABLE grupo_usuario (
    id int PRIMARY KEY IDENTITY,
    usuario_id integer NOT NULL,
    grupo_id integer NOT NULL
);

-- SÓ DEIXOU INSERIR UM TIMESTAMP, MUDEI PRA DATETIME
CREATE TABLE prova (
    id int PRIMARY KEY IDENTITY,
    nome text NOT NULL,
    sucinto text NOT NULL,
    minutos_realizacao integer,
    cor_primaria text NOT NULL,
    cor_secundaria text NOT NULL,
    usuario_responsavel integer NOT NULL,
    is_publica char DEFAULT 0 NOT NULL,
    inicio datetime default CURRENT_TIMESTAMP NOT NULL,
    fim datetime NOT NULL
);

CREATE TABLE questao (
    id int PRIMARY KEY IDENTITY,
    pergunta text NOT NULL,
    is_multipla_escolha CHAR DEFAULT 1 NOT NULL,
    prova_id integer NOT NULL,
    minutos_realizacao integer,
    peso numeric(10,3) NOT NULL,
    is_obrigatoria CHAR DEFAULT 1 NOT NULL
);


CREATE TABLE questao_usuario_prova (
    id int PRIMARY KEY IDENTITY,
    questao_id integer NOT NULL,
    usuario_prova_id integer NOT NULL,
    resposta_usuario text,
    peso numeric(10,3) NOT NULL,
    dt_registro datetime default CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE resposta (
    id int PRIMARY KEY IDENTITY,
    questao_id integer NOT NULL,
    resposta text NOT NULL
);

CREATE TABLE system_access_log (
    id int PRIMARY KEY IDENTITY,
    sessionid text,
    login text,
    login_time datetime default CURRENT_TIMESTAMP,
    login_year character varying(4),
    login_month character varying(2),
    login_day character varying(2),
    logout_time datetime default CURRENT_TIMESTAMP,
    impersonated character(1),
    access_ip character varying(45)
);

insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (1, 'bds60u2ag58rigk31p814b88t8', 'admin', '2021-03-10 13:32:05', '2021', '03', '10', NULL, NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (2, 'l8abdvh7f7889b4sk1pe7eavpg', 'admin', '2021-03-10 14:27:58', '2021', '03', '10', '2021-03-10 14:28:27',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (3, 'o9knius0kmjhp4s0hg2oo6soao', 'admin', '2021-03-10 14:28:30', '2021', '03', '10', '2021-03-10 14:29:26',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (4, 'o4jqr5ssjc8odivihjec6kgnd0', 'admin', '2021-03-10 14:29:29', '2021', '03', '10', '2021-03-10 14:31:28',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (5, 'rcibh77vrohste56lockmh4lnl', 'admin', '2021-03-10 14:31:31', '2021', '03', '10', '2021-03-10 14:34:37',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (6, '0eag3dgb19pc5e6p14n3d89rj4', 'admin', '2021-03-10 14:34:40', '2021', '03', '10', '2021-03-10 14:38:08',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (7, 'c3c4pbqosr35m0mjn6rstn42a5', 'admin', '2021-03-10 14:38:10', '2021', '03', '10', '2021-03-10 14:38:24',	NULL, NULL);
insert into system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) values (8, '49pu0o72g3n7p1inisj2711a09', 'admin', '2021-03-10 14:38:27', '2021', '03', '10', NULL, NULL, NULL);


CREATE TABLE system_change_log (
    id int PRIMARY KEY IDENTITY,
    logdate datetime default CURRENT_TIMESTAMP,
    login text,
    tablename text,
    primarykey text,
    pkvalue text,
    operation text,
    columnname text,
    oldvalue text,
    newvalue text,
    access_ip text,
    transaction_id text,
    log_trace text,
    session_id text,
    class_name text,
    php_sapi text,
    log_year character varying(4),
    log_month character varying(2),
    log_day character varying(2)
);

CREATE TABLE system_document (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    title text,
    description text,
    category_id integer,
    submission_date date,
    archive_date date,
    filename text
);

CREATE TABLE system_document_category (
    id int PRIMARY KEY IDENTITY,
    name text
);

insert into system_document_category (id, name) VALUES 
(1,	'Documentação');

CREATE TABLE system_document_group (
    id int PRIMARY KEY IDENTITY,
    document_id integer,
    system_group_id integer
);

CREATE TABLE system_document_user (
    id int PRIMARY KEY IDENTITY,
    document_id integer,
    system_user_id integer
);

CREATE TABLE system_group (
    id int PRIMARY KEY IDENTITY,
    name character varying(100)
);

INSERT INTO system_group (id, name) VALUES (1, 'Admin');
INSERT INTO system_group (id, name) VALUES (2, 'Standard');

CREATE TABLE system_group_program (
    id int PRIMARY KEY IDENTITY,
    system_group_id integer,
    system_program_id integer
);

INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (12,	2,	10);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (13,	2,	12);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (14,	2,	13);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (15,	2,	16);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (16,	2,	17);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (17,	2,	18);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (18,	2,	19);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (19,	2,	20);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (21,	2,	22);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (22,	2,	23);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (23,	2,	24);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (24,	2,	25);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (29,	2,	30);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (30,	1,	1);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (31,	1,	2);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (32,	1,	3);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (33,	1,	4);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (34,	1,	5);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (35,	1,	6);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (36,	1,	7);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (37,	1,	8);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (38,	1,	9);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (39,	1,	10);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (40,	1,	11);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (41,	1,	12);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (42,	1,	13);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (43,	1,	14);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (44,	1,	15);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (45,	1,	16);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (46,	1,	17);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (47,	1,	18);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (48,	1,	19);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (49,	1,	20);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (50,	1,	21);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (51,	1,	22);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (52,	1,	23);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (53,	1,	24);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (54,	1,	25);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (55,	1,	26);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (56,	1,	27);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (57,	1,	28);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (58,	1,	29);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (59,	1,	30);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (60,	1,	31);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (61,	1,	32);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (62,	1,	33);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (63,	1,	34);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (64,	1,	35);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (65,	1,	36);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (66,	1,	37);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (67,	1,	38);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (68,	1,	39);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (69,	1,	40);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (70,	1,	41);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (71,	1,	42);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (72,	1,	43);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (73,	1,	44);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (74,	1,	45);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (75,	1,	46);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (76,	1,	47);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (77,	1,	48);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (78,	1,	49);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (79,	1,	50);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (80,	1,	51);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (81,	1,	52);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (82,	1,	53);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (83,	1,	54);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (84,	1,	55);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (85,	1,	56);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (86,	1,	57);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (87,	1,	58);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (89,	1,	60);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (90,	1,	61);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (91,	1,	62);
INSERT INTO system_group_program (id, system_group_id, system_program_id) VALUES (92,	1,	59);

CREATE TABLE system_message (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    system_user_to_id integer,
    subject text,
    message text,
    dt_message text,
    checked character(1)
);

CREATE TABLE system_notification (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    system_user_to_id integer,
    subject text,
    message text,
    dt_message text,
    action_url text,
    action_label text,
    icon text,
    checked character(1)
);

CREATE TABLE system_preference (
    id int PRIMARY KEY IDENTITY,
);

CREATE TABLE system_program (
    id int PRIMARY KEY IDENTITY,
    name character varying(100),
    controller character varying(100)
);

INSERT INTO system_program (id, name, controller) VALUES (1, 'System Group Form',	'SystemGroupForm');
INSERT INTO system_program (id, name, controller) VALUES (2, 'System Group List',	'SystemGroupList');
INSERT INTO system_program (id, name, controller) VALUES (3, 'System Program Form',	'SystemProgramForm');
INSERT INTO system_program (id, name, controller) VALUES (4, 'System Program List',	'SystemProgramList');
INSERT INTO system_program (id, name, controller) VALUES (5, 'System User Form',	'SystemUserForm');
INSERT INTO system_program (id, name, controller) VALUES (6, 'System User List',	'SystemUserList');
INSERT INTO system_program (id, name, controller) VALUES (7, 'Common Page',	'CommonPage');
INSERT INTO system_program (id, name, controller) VALUES (8, 'System PHP Info',	'SystemPHPInfoView');
INSERT INTO system_program (id, name, controller) VALUES (9, 'System ChangeLog View',	'SystemChangeLogView');
INSERT INTO system_program (id, name, controller) VALUES (10, 'Welcome View',	'WelcomeView');
INSERT INTO system_program (id, name, controller) VALUES (11, 'System Sql Log',	'SystemSqlLogList');
INSERT INTO system_program (id, name, controller) VALUES (12, 'System Profile View',	'SystemProfileView');
INSERT INTO system_program (id, name, controller) VALUES (13, 'System Profile Form',	'SystemProfileForm');
INSERT INTO system_program (id, name, controller) VALUES (14, 'System SQL Panel',	'SystemSQLPanel');
INSERT INTO system_program (id, name, controller) VALUES (15, 'System Access Log',	'SystemAccessLogList');
INSERT INTO system_program (id, name, controller) VALUES (16, 'System Message Form',	'SystemMessageForm');
INSERT INTO system_program (id, name, controller) VALUES (17, 'System Message List',	'SystemMessageList');
INSERT INTO system_program (id, name, controller) VALUES (18, 'System Message Form View',	'SystemMessageFormView');
INSERT INTO system_program (id, name, controller) VALUES (19, 'System Notification List',	'SystemNotificationList');
INSERT INTO system_program (id, name, controller) VALUES (20, 'System Notification Form View',	'SystemNotificationFormView');
INSERT INTO system_program (id, name, controller) VALUES (21, 'System Document Category List',	'SystemDocumentCategoryFormList');
INSERT INTO system_program (id, name, controller) VALUES (22, 'System Document Form',	'SystemDocumentForm');
INSERT INTO system_program (id, name, controller) VALUES (23, 'System Document Upload Form',	'SystemDocumentUploadForm');
INSERT INTO system_program (id, name, controller) VALUES (24, 'System Document List',	'SystemDocumentList');
INSERT INTO system_program (id, name, controller) VALUES (25, 'System Shared Document List',	'SystemSharedDocumentList');
INSERT INTO system_program (id, name, controller) VALUES (26, 'System Unit Form',	'SystemUnitForm');
INSERT INTO system_program (id, name, controller) VALUES (27, 'System Unit List',	'SystemUnitList');
INSERT INTO system_program (id, name, controller) VALUES (28, 'System Access stats',	'SystemAccessLogStats');
INSERT INTO system_program (id, name, controller) VALUES (29, 'System Preference form',	'SystemPreferenceForm');
INSERT INTO system_program (id, name, controller) VALUES (30, 'System Support form',	'SystemSupportForm');
INSERT INTO system_program (id, name, controller) VALUES (31, 'System PHP Error',	'SystemPHPErrorLogView');
INSERT INTO system_program (id, name, controller) VALUES (32, 'System Database Browser',	'SystemDatabaseExplorer');
INSERT INTO system_program (id, name, controller) VALUES (33, 'System Table List',	'SystemTableList');
INSERT INTO system_program (id, name, controller) VALUES (34, 'System Data Browser',	'SystemDataBrowser');
INSERT INTO system_program (id, name, controller) VALUES (35, 'System Menu Editor',	'SystemMenuEditor');
INSERT INTO system_program (id, name, controller) VALUES (36, 'System Request Log',	'SystemRequestLogList');
INSERT INTO system_program (id, name, controller) VALUES (37, 'System Request Log View',	'SystemRequestLogView');
INSERT INTO system_program (id, name, controller) VALUES (38, 'System Administration Dashboard',	'SystemAdministrationDashboard');
INSERT INTO system_program (id, name, controller) VALUES (39, 'System Log Dashboard',	'SystemLogDashboard');
INSERT INTO system_program (id, name, controller) VALUES (40, 'System Session dump',	'SystemSessionDumpView');
INSERT INTO system_program (id, name, controller) VALUES (62, 'UsuarioProvaHeaderList',	'UsuarioHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (59, 'UsuarioForm',	'UsuarioForm');
INSERT INTO system_program (id, name, controller) VALUES (41, 'AlternativaForm',	'AlternativaForm');
INSERT INTO system_program (id, name, controller) VALUES (42, 'AlternativaHeaderList',	'AlternativaHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (43, 'AlternativaRespostaQuestaoForm',	'AlternativaRespostaQuestaoForm');
INSERT INTO system_program (id, name, controller) VALUES (44, 'AlternativaRespostaQuestaoHeaderList',	'AlternativaRespostaQuestaoHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (45, 'GrupoForm',	'GrupoForm');
INSERT INTO system_program (id, name, controller) VALUES (46, 'GrupoHeaderList',	'GrupoHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (47, 'GrupoProvaForm',	'GrupoProvaForm');
INSERT INTO system_program (id, name, controller) VALUES (48, 'GrupoProvaHeaderList',	'GrupoProvaHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (49, 'GrupoUsuarioForm',	'GrupoUsuarioForm');
INSERT INTO system_program (id, name, controller) VALUES (50, 'GrupoUsuarioHeaderList',	'GrupoUsuarioHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (51, 'ProvaForm',	'ProvaForm');
INSERT INTO system_program (id, name, controller) VALUES (52, 'ProvaHeaderList',	'ProvaHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (53, 'QuestaoForm',	'QuestaoForm');
INSERT INTO system_program (id, name, controller) VALUES (54, 'QuestaoHeaderList',	'QuestaoHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (55, 'QuestaoUsuarioProvaForm',	'QuestaoUsuarioProvaForm');
INSERT INTO system_program (id, name, controller) VALUES (56, 'QuestaoUsuarioProvaHeaderList',	'QuestaoUsuarioProvaHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (57, 'RespostaForm',	'RespostaForm');
INSERT INTO system_program (id, name, controller) VALUES (58, 'RespostaHeaderList',	'RespostaHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (60, 'UsuarioHeaderList',	'UsuarioHeaderList');
INSERT INTO system_program (id, name, controller) VALUES (61, 'UsuarioProvaForm',	'UsuarioProvaForm');

CREATE TABLE system_request_log (
    id int PRIMARY KEY IDENTITY,
    endpoint text,
    logdate text,
    log_year character varying(4),
    log_month character varying(2),
    log_day character varying(2),
    session_id text,
    login text,
    access_ip text,
    class_name text,
    http_host text,
    server_port text,
    request_uri text,
    request_method text,
    query_string text,
    request_headers text,
    request_body text,
    request_duration integer
);

CREATE TABLE system_sql_log (
    id int PRIMARY KEY IDENTITY,
    logdate datetime default CURRENT_TIMESTAMP,
    login text,
    database_name text,
    sql_command text,
    statement_type text,
    access_ip character varying(45),
    transaction_id text,
    log_trace text,
    session_id text,
    class_name text,
    php_sapi text,
    request_id text,
    log_year character varying(4),
    log_month character varying(2),
    log_day character varying(2)
);

CREATE TABLE system_unit (
    id int PRIMARY KEY IDENTITY,
    name character varying(100),
    connection_name character varying(100)
);

INSERT INTO system_unit (id, name, connection_name) VALUES (1, 'Unit A', 'unit_a');
INSERT INTO system_unit (id, name, connection_name) VALUES (2, 'Unit B', 'unit_b');


CREATE TABLE usuario_sistema (
    id int PRIMARY KEY IDENTITY,
    name character varying(100),
    login character varying(100),
    password character varying(100),
    email character varying(100),
    frontpage_id integer,
    system_unit_id integer,
    active character(1)
);

INSERT INTO usuario_sistema (id, name, login, password, email, frontpage_id, system_unit_id, active) VALUES (1, 'Administrator',	'admin',	'21232f297a57a5a743894a0e4a801fc3',	'admin@admin.net',	10,	NULL, 'Y');
INSERT INTO usuario_sistema (id, name, login, password, email, frontpage_id, system_unit_id, active) VALUES (2, 'User',	'user',	'ee11cbb19052e40b07aac0ca060c23ee',	'user@user.net',	7,	NULL, 'Y');


CREATE TABLE system_user_group (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    system_group_id integer
);

INSERT INTO system_user_group (id, system_user_id, system_group_id) VALUES (2,	2,	2);
INSERT INTO system_user_group (id, system_user_id, system_group_id) VALUES (3,	1,	2);
INSERT INTO system_user_group (id, system_user_id, system_group_id) VALUES (4,	1,	1);


CREATE TABLE system_user_program (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    system_program_id integer
);

INSERT INTO system_user_program (id, system_user_id, system_program_id) VALUES  (1,	2,	7);

CREATE TABLE system_user_unit (
    id int PRIMARY KEY IDENTITY,
    system_user_id integer,
    system_unit_id integer
);

INSERT INTO system_user_unit (id, system_user_id, system_unit_id) VALUES (1,	1,	1);
INSERT INTO system_user_unit (id, system_user_id, system_unit_id) VALUES (2,	1,	2);
INSERT INTO system_user_unit (id, system_user_id, system_unit_id) VALUES (3,	2,	1);
INSERT INTO system_user_unit (id, system_user_id, system_unit_id) VALUES (4,	2,	2);

CREATE TABLE usuario (
    id int PRIMARY KEY IDENTITY,
    nome text NOT NULL,
    email text NOT NULL,
    senha text NOT NULL,
    is_professor CHAR DEFAULT 0 NOT NULL
);

CREATE TABLE usuario_prova (
    id int PRIMARY KEY IDENTITY,
    usuario_id integer NOT NULL,
    prova_id integer NOT NULL,
    inicio datetime default CURRENT_TIMESTAMP NOT NULL,
    fim datetime
);

CREATE TABLE usuario (
    id int PRIMARY KEY IDENTITY,
    nome text NOT NULL,
    email text NOT NULL,
    senha text NOT NULL,
    is_professor CHAR DEFAULT 0 NOT NULL  
);

