--
-- PostgreSQL database dump
--

-- Dumped from database version 10.15 (Ubuntu 10.15-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.15 (Ubuntu 10.15-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: alternativa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.alternativa (
    id integer NOT NULL,
    questao_id integer NOT NULL,
    descricao text NOT NULL,
    is_correta boolean DEFAULT false NOT NULL
);


ALTER TABLE public.alternativa OWNER TO postgres;

--
-- Name: alternativa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.alternativa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alternativa_id_seq OWNER TO postgres;

--
-- Name: alternativa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.alternativa_id_seq OWNED BY public.alternativa.id;


--
-- Name: alternativa_resposta_questao; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.alternativa_resposta_questao (
    id integer NOT NULL,
    alternativa_id integer NOT NULL,
    questao_usuario_prova_id integer NOT NULL
);


ALTER TABLE public.alternativa_resposta_questao OWNER TO postgres;

--
-- Name: alternativa_resposta_questao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.alternativa_resposta_questao_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.alternativa_resposta_questao_id_seq OWNER TO postgres;

--
-- Name: alternativa_resposta_questao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.alternativa_resposta_questao_id_seq OWNED BY public.alternativa_resposta_questao.id;


--
-- Name: grupo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.grupo (
    id integer NOT NULL,
    nome text NOT NULL,
    descricao text NOT NULL
);


ALTER TABLE public.grupo OWNER TO postgres;

--
-- Name: grupo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.grupo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_id_seq OWNER TO postgres;

--
-- Name: grupo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.grupo_id_seq OWNED BY public.grupo.id;


--
-- Name: grupo_prova; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.grupo_prova (
    id integer NOT NULL,
    prova_id integer NOT NULL,
    grupo_id integer NOT NULL
);


ALTER TABLE public.grupo_prova OWNER TO postgres;

--
-- Name: grupo_prova_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.grupo_prova_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_prova_id_seq OWNER TO postgres;

--
-- Name: grupo_prova_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.grupo_prova_id_seq OWNED BY public.grupo_prova.id;


--
-- Name: grupo_usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.grupo_usuario (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    grupo_id integer NOT NULL
);


ALTER TABLE public.grupo_usuario OWNER TO postgres;

--
-- Name: grupo_usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.grupo_usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupo_usuario_id_seq OWNER TO postgres;

--
-- Name: grupo_usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.grupo_usuario_id_seq OWNED BY public.grupo_usuario.id;


--
-- Name: prova; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.prova (
    id integer NOT NULL,
    nome text NOT NULL,
    sucinto text NOT NULL,
    minutos_realizacao integer,
    cor_primaria text NOT NULL,
    cor_secundaria text NOT NULL,
    usuario_responsavel integer NOT NULL,
    is_publica boolean DEFAULT false NOT NULL,
    inicio timestamp without time zone DEFAULT now() NOT NULL,
    fim timestamp without time zone NOT NULL
);


ALTER TABLE public.prova OWNER TO postgres;

--
-- Name: prova_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.prova_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.prova_id_seq OWNER TO postgres;

--
-- Name: prova_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.prova_id_seq OWNED BY public.prova.id;


--
-- Name: questao; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.questao (
    id integer NOT NULL,
    pergunta text NOT NULL,
    is_multipla_escolha boolean DEFAULT true NOT NULL,
    prova_id integer NOT NULL,
    minutos_realizacao integer,
    peso numeric(10,3) NOT NULL,
    is_obrigatoria boolean DEFAULT true NOT NULL
);


ALTER TABLE public.questao OWNER TO postgres;

--
-- Name: questao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.questao_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questao_id_seq OWNER TO postgres;

--
-- Name: questao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.questao_id_seq OWNED BY public.questao.id;


--
-- Name: questao_usuario_prova; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.questao_usuario_prova (
    id integer NOT NULL,
    questao_id integer NOT NULL,
    usuario_prova_id integer NOT NULL,
    resposta_usuario text,
    peso numeric(10,3) NOT NULL,
    dt_registro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.questao_usuario_prova OWNER TO postgres;

--
-- Name: questao_usuario_prova_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.questao_usuario_prova_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questao_usuario_prova_id_seq OWNER TO postgres;

--
-- Name: questao_usuario_prova_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.questao_usuario_prova_id_seq OWNED BY public.questao_usuario_prova.id;


--
-- Name: resposta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.resposta (
    id integer NOT NULL,
    questao_id integer NOT NULL,
    resposta text NOT NULL
);


ALTER TABLE public.resposta OWNER TO postgres;

--
-- Name: resposta_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.resposta_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.resposta_id_seq OWNER TO postgres;

--
-- Name: resposta_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.resposta_id_seq OWNED BY public.resposta.id;


--
-- Name: system_access_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_access_log (
    id integer NOT NULL,
    sessionid text,
    login text,
    login_time timestamp without time zone,
    login_year character varying(4),
    login_month character varying(2),
    login_day character varying(2),
    logout_time timestamp without time zone,
    impersonated character(1),
    access_ip character varying(45)
);


ALTER TABLE public.system_access_log OWNER TO postgres;

--
-- Name: system_change_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_change_log (
    id integer NOT NULL,
    logdate timestamp without time zone,
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


ALTER TABLE public.system_change_log OWNER TO postgres;

--
-- Name: system_document; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_document (
    id integer NOT NULL,
    system_user_id integer,
    title text,
    description text,
    category_id integer,
    submission_date date,
    archive_date date,
    filename text
);


ALTER TABLE public.system_document OWNER TO postgres;

--
-- Name: system_document_category; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_document_category (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.system_document_category OWNER TO postgres;

--
-- Name: system_document_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_document_group (
    id integer NOT NULL,
    document_id integer,
    system_group_id integer
);


ALTER TABLE public.system_document_group OWNER TO postgres;

--
-- Name: system_document_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_document_user (
    id integer NOT NULL,
    document_id integer,
    system_user_id integer
);


ALTER TABLE public.system_document_user OWNER TO postgres;

--
-- Name: system_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_group (
    id integer NOT NULL,
    name character varying(100)
);


ALTER TABLE public.system_group OWNER TO postgres;

--
-- Name: system_group_program; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_group_program (
    id integer NOT NULL,
    system_group_id integer,
    system_program_id integer
);


ALTER TABLE public.system_group_program OWNER TO postgres;

--
-- Name: system_message; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_message (
    id integer NOT NULL,
    system_user_id integer,
    system_user_to_id integer,
    subject text,
    message text,
    dt_message text,
    checked character(1)
);


ALTER TABLE public.system_message OWNER TO postgres;

--
-- Name: system_notification; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_notification (
    id integer NOT NULL,
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


ALTER TABLE public.system_notification OWNER TO postgres;

--
-- Name: system_preference; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_preference (
    id text,
    value text
);


ALTER TABLE public.system_preference OWNER TO postgres;

--
-- Name: system_program; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_program (
    id integer NOT NULL,
    name character varying(100),
    controller character varying(100)
);


ALTER TABLE public.system_program OWNER TO postgres;

--
-- Name: system_request_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_request_log (
    id integer NOT NULL,
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


ALTER TABLE public.system_request_log OWNER TO postgres;

--
-- Name: system_sql_log; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_sql_log (
    id integer NOT NULL,
    logdate timestamp without time zone,
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


ALTER TABLE public.system_sql_log OWNER TO postgres;

--
-- Name: system_unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_unit (
    id integer NOT NULL,
    name character varying(100),
    connection_name character varying(100)
);


ALTER TABLE public.system_unit OWNER TO postgres;

--
-- Name: system_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_user (
    id integer NOT NULL,
    name character varying(100),
    login character varying(100),
    password character varying(100),
    email character varying(100),
    frontpage_id integer,
    system_unit_id integer,
    active character(1)
);


ALTER TABLE public.system_user OWNER TO postgres;

--
-- Name: system_user_group; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_user_group (
    id integer NOT NULL,
    system_user_id integer,
    system_group_id integer
);


ALTER TABLE public.system_user_group OWNER TO postgres;

--
-- Name: system_user_program; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_user_program (
    id integer NOT NULL,
    system_user_id integer,
    system_program_id integer
);


ALTER TABLE public.system_user_program OWNER TO postgres;

--
-- Name: system_user_unit; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.system_user_unit (
    id integer NOT NULL,
    system_user_id integer,
    system_unit_id integer
);


ALTER TABLE public.system_user_unit OWNER TO postgres;

--
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id integer NOT NULL,
    nome text NOT NULL,
    email text NOT NULL,
    senha text NOT NULL,
    is_professor boolean DEFAULT false NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO postgres;

--
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;


--
-- Name: usuario_prova; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario_prova (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    prova_id integer NOT NULL,
    inicio timestamp without time zone DEFAULT now() NOT NULL,
    fim timestamp without time zone
);


ALTER TABLE public.usuario_prova OWNER TO postgres;

--
-- Name: usuario_prova_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_prova_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_prova_id_seq OWNER TO postgres;

--
-- Name: usuario_prova_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_prova_id_seq OWNED BY public.usuario_prova.id;


--
-- Name: alternativa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa ALTER COLUMN id SET DEFAULT nextval('public.alternativa_id_seq'::regclass);


--
-- Name: alternativa_resposta_questao id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa_resposta_questao ALTER COLUMN id SET DEFAULT nextval('public.alternativa_resposta_questao_id_seq'::regclass);


--
-- Name: grupo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo ALTER COLUMN id SET DEFAULT nextval('public.grupo_id_seq'::regclass);


--
-- Name: grupo_prova id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_prova ALTER COLUMN id SET DEFAULT nextval('public.grupo_prova_id_seq'::regclass);


--
-- Name: grupo_usuario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_usuario ALTER COLUMN id SET DEFAULT nextval('public.grupo_usuario_id_seq'::regclass);


--
-- Name: prova id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prova ALTER COLUMN id SET DEFAULT nextval('public.prova_id_seq'::regclass);


--
-- Name: questao id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao ALTER COLUMN id SET DEFAULT nextval('public.questao_id_seq'::regclass);


--
-- Name: questao_usuario_prova id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao_usuario_prova ALTER COLUMN id SET DEFAULT nextval('public.questao_usuario_prova_id_seq'::regclass);


--
-- Name: resposta id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resposta ALTER COLUMN id SET DEFAULT nextval('public.resposta_id_seq'::regclass);


--
-- Name: usuario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);


--
-- Name: usuario_prova id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_prova ALTER COLUMN id SET DEFAULT nextval('public.usuario_prova_id_seq'::regclass);


--
-- Data for Name: alternativa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.alternativa (id, questao_id, descricao, is_correta) FROM stdin;
\.


--
-- Data for Name: alternativa_resposta_questao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.alternativa_resposta_questao (id, alternativa_id, questao_usuario_prova_id) FROM stdin;
\.


--
-- Data for Name: grupo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.grupo (id, nome, descricao) FROM stdin;
1	Primeiro Grupo	testando cadastro de grupos
\.


--
-- Data for Name: grupo_prova; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.grupo_prova (id, prova_id, grupo_id) FROM stdin;
\.


--
-- Data for Name: grupo_usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.grupo_usuario (id, usuario_id, grupo_id) FROM stdin;
\.


--
-- Data for Name: prova; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.prova (id, nome, sucinto, minutos_realizacao, cor_primaria, cor_secundaria, usuario_responsavel, is_publica, inicio, fim) FROM stdin;
\.


--
-- Data for Name: questao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.questao (id, pergunta, is_multipla_escolha, prova_id, minutos_realizacao, peso, is_obrigatoria) FROM stdin;
\.


--
-- Data for Name: questao_usuario_prova; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.questao_usuario_prova (id, questao_id, usuario_prova_id, resposta_usuario, peso, dt_registro) FROM stdin;
\.


--
-- Data for Name: resposta; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.resposta (id, questao_id, resposta) FROM stdin;
\.


--
-- Data for Name: system_access_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_access_log (id, sessionid, login, login_time, login_year, login_month, login_day, logout_time, impersonated, access_ip) FROM stdin;
1	bds60u2ag58rigk31p814b88t8	admin	2021-03-10 13:32:05	2021	03	10	\N	N	::1
2	l8abdvh7f7889b4sk1pe7eavpg	admin	2021-03-10 14:27:58	2021	03	10	2021-03-10 14:28:27	N	::1
3	o9knius0kmjhp4s0hg2oo6soao	admin	2021-03-10 14:28:30	2021	03	10	2021-03-10 14:29:26	N	::1
4	o4jqr5ssjc8odivihjec6kgnd0	admin	2021-03-10 14:29:29	2021	03	10	2021-03-10 14:31:28	N	::1
5	rcibh77vrohste56lockmh4lnl	admin	2021-03-10 14:31:31	2021	03	10	2021-03-10 14:34:37	N	::1
6	0eag3dgb19pc5e6p14n3d89rj4	admin	2021-03-10 14:34:40	2021	03	10	2021-03-10 14:38:08	N	::1
7	c3c4pbqosr35m0mjn6rstn42a5	admin	2021-03-10 14:38:10	2021	03	10	2021-03-10 14:38:24	N	::1
8	49pu0o72g3n7p1inisj2711a09	admin	2021-03-10 14:38:27	2021	03	10	\N	N	::1
\.


--
-- Data for Name: system_change_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_change_log (id, logdate, login, tablename, primarykey, pkvalue, operation, columnname, oldvalue, newvalue, access_ip, transaction_id, log_trace, session_id, class_name, php_sapi, log_year, log_month, log_day) FROM stdin;
\.


--
-- Data for Name: system_document; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_document (id, system_user_id, title, description, category_id, submission_date, archive_date, filename) FROM stdin;
\.


--
-- Data for Name: system_document_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_document_category (id, name) FROM stdin;
1	Documentação
\.


--
-- Data for Name: system_document_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_document_group (id, document_id, system_group_id) FROM stdin;
\.


--
-- Data for Name: system_document_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_document_user (id, document_id, system_user_id) FROM stdin;
\.


--
-- Data for Name: system_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_group (id, name) FROM stdin;
2	Standard
1	Admin
\.


--
-- Data for Name: system_group_program; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_group_program (id, system_group_id, system_program_id) FROM stdin;
12	2	10
13	2	12
14	2	13
15	2	16
16	2	17
17	2	18
18	2	19
19	2	20
21	2	22
22	2	23
23	2	24
24	2	25
29	2	30
30	1	1
31	1	2
32	1	3
33	1	4
34	1	5
35	1	6
36	1	7
37	1	8
38	1	9
39	1	10
40	1	11
41	1	12
42	1	13
43	1	14
44	1	15
45	1	16
46	1	17
47	1	18
48	1	19
49	1	20
50	1	21
51	1	22
52	1	23
53	1	24
54	1	25
55	1	26
56	1	27
57	1	28
58	1	29
59	1	30
60	1	31
61	1	32
62	1	33
63	1	34
64	1	35
65	1	36
66	1	37
67	1	38
68	1	39
69	1	40
70	1	41
71	1	42
72	1	43
73	1	44
74	1	45
75	1	46
76	1	47
77	1	48
78	1	49
79	1	50
80	1	51
81	1	52
82	1	53
83	1	54
84	1	55
85	1	56
86	1	57
87	1	58
89	1	60
90	1	61
91	1	62
92	1	59
\.


--
-- Data for Name: system_message; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_message (id, system_user_id, system_user_to_id, subject, message, dt_message, checked) FROM stdin;
\.


--
-- Data for Name: system_notification; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_notification (id, system_user_id, system_user_to_id, subject, message, dt_message, action_url, action_label, icon, checked) FROM stdin;
\.


--
-- Data for Name: system_preference; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_preference (id, value) FROM stdin;
\.


--
-- Data for Name: system_program; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_program (id, name, controller) FROM stdin;
1	System Group Form	SystemGroupForm
2	System Group List	SystemGroupList
3	System Program Form	SystemProgramForm
4	System Program List	SystemProgramList
5	System User Form	SystemUserForm
6	System User List	SystemUserList
7	Common Page	CommonPage
8	System PHP Info	SystemPHPInfoView
9	System ChangeLog View	SystemChangeLogView
10	Welcome View	WelcomeView
11	System Sql Log	SystemSqlLogList
12	System Profile View	SystemProfileView
13	System Profile Form	SystemProfileForm
14	System SQL Panel	SystemSQLPanel
15	System Access Log	SystemAccessLogList
16	System Message Form	SystemMessageForm
17	System Message List	SystemMessageList
18	System Message Form View	SystemMessageFormView
19	System Notification List	SystemNotificationList
20	System Notification Form View	SystemNotificationFormView
21	System Document Category List	SystemDocumentCategoryFormList
22	System Document Form	SystemDocumentForm
23	System Document Upload Form	SystemDocumentUploadForm
24	System Document List	SystemDocumentList
25	System Shared Document List	SystemSharedDocumentList
26	System Unit Form	SystemUnitForm
27	System Unit List	SystemUnitList
28	System Access stats	SystemAccessLogStats
29	System Preference form	SystemPreferenceForm
30	System Support form	SystemSupportForm
31	System PHP Error	SystemPHPErrorLogView
32	System Database Browser	SystemDatabaseExplorer
33	System Table List	SystemTableList
34	System Data Browser	SystemDataBrowser
35	System Menu Editor	SystemMenuEditor
36	System Request Log	SystemRequestLogList
37	System Request Log View	SystemRequestLogView
38	System Administration Dashboard	SystemAdministrationDashboard
39	System Log Dashboard	SystemLogDashboard
40	System Session dump	SystemSessionDumpView
62	UsuarioProvaHeaderList	UsuarioHeaderList
59	UsuarioForm	UsuarioForm
41	AlternativaForm	AlternativaForm
42	AlternativaHeaderList	AlternativaHeaderList
43	AlternativaRespostaQuestaoForm	AlternativaRespostaQuestaoForm
44	AlternativaRespostaQuestaoHeaderList	AlternativaRespostaQuestaoHeaderList
45	GrupoForm	GrupoForm
46	GrupoHeaderList	GrupoHeaderList
47	GrupoProvaForm	GrupoProvaForm
48	GrupoProvaHeaderList	GrupoProvaHeaderList
49	GrupoUsuarioForm	GrupoUsuarioForm
50	GrupoUsuarioHeaderList	GrupoUsuarioHeaderList
51	ProvaForm	ProvaForm
52	ProvaHeaderList	ProvaHeaderList
53	QuestaoForm	QuestaoForm
54	QuestaoHeaderList	QuestaoHeaderList
55	QuestaoUsuarioProvaForm	QuestaoUsuarioProvaForm
56	QuestaoUsuarioProvaHeaderList	QuestaoUsuarioProvaHeaderList
57	RespostaForm	RespostaForm
58	RespostaHeaderList	RespostaHeaderList
60	UsuarioHeaderList	UsuarioHeaderList
61	UsuarioProvaForm	UsuarioProvaForm
\.


--
-- Data for Name: system_request_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_request_log (id, endpoint, logdate, log_year, log_month, log_day, session_id, login, access_ip, class_name, http_host, server_port, request_uri, request_method, query_string, request_headers, request_body, request_duration) FROM stdin;
\.


--
-- Data for Name: system_sql_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_sql_log (id, logdate, login, database_name, sql_command, statement_type, access_ip, transaction_id, log_trace, session_id, class_name, php_sapi, request_id, log_year, log_month, log_day) FROM stdin;
\.


--
-- Data for Name: system_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_unit (id, name, connection_name) FROM stdin;
1	Unit A	unit_a
2	Unit B	unit_b
\.


--
-- Data for Name: system_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_user (id, name, login, password, email, frontpage_id, system_unit_id, active) FROM stdin;
1	Administrator	admin	21232f297a57a5a743894a0e4a801fc3	admin@admin.net	10	\N	Y
2	User	user	ee11cbb19052e40b07aac0ca060c23ee	user@user.net	7	\N	Y
\.


--
-- Data for Name: system_user_group; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_user_group (id, system_user_id, system_group_id) FROM stdin;
2	2	2
3	1	2
4	1	1
\.


--
-- Data for Name: system_user_program; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_user_program (id, system_user_id, system_program_id) FROM stdin;
1	2	7
\.


--
-- Data for Name: system_user_unit; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.system_user_unit (id, system_user_id, system_unit_id) FROM stdin;
1	1	1
2	1	2
3	2	1
4	2	2
\.


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario (id, nome, email, senha, is_professor) FROM stdin;
\.


--
-- Data for Name: usuario_prova; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario_prova (id, usuario_id, prova_id, inicio, fim) FROM stdin;
\.


--
-- Name: alternativa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.alternativa_id_seq', 1, false);


--
-- Name: alternativa_resposta_questao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.alternativa_resposta_questao_id_seq', 1, false);


--
-- Name: grupo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.grupo_id_seq', 1, true);


--
-- Name: grupo_prova_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.grupo_prova_id_seq', 1, false);


--
-- Name: grupo_usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.grupo_usuario_id_seq', 1, false);


--
-- Name: prova_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.prova_id_seq', 1, false);


--
-- Name: questao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.questao_id_seq', 1, false);


--
-- Name: questao_usuario_prova_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.questao_usuario_prova_id_seq', 1, false);


--
-- Name: resposta_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.resposta_id_seq', 1, false);


--
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_seq', 1, false);


--
-- Name: usuario_prova_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_prova_id_seq', 1, false);


--
-- Name: alternativa alternativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa
    ADD CONSTRAINT alternativa_pkey PRIMARY KEY (id);


--
-- Name: alternativa_resposta_questao alternativa_resposta_questao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa_resposta_questao
    ADD CONSTRAINT alternativa_resposta_questao_pkey PRIMARY KEY (id);


--
-- Name: grupo grupo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo
    ADD CONSTRAINT grupo_pkey PRIMARY KEY (id);


--
-- Name: grupo_prova grupo_prova_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_prova
    ADD CONSTRAINT grupo_prova_pkey PRIMARY KEY (id);


--
-- Name: grupo_usuario grupo_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_usuario
    ADD CONSTRAINT grupo_usuario_pkey PRIMARY KEY (id);


--
-- Name: prova prova_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prova
    ADD CONSTRAINT prova_pkey PRIMARY KEY (id);


--
-- Name: questao questao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao
    ADD CONSTRAINT questao_pkey PRIMARY KEY (id);


--
-- Name: questao_usuario_prova questao_usuario_prova_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao_usuario_prova
    ADD CONSTRAINT questao_usuario_prova_pkey PRIMARY KEY (id);


--
-- Name: resposta resposta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resposta
    ADD CONSTRAINT resposta_pkey PRIMARY KEY (id);


--
-- Name: system_access_log system_access_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_access_log
    ADD CONSTRAINT system_access_log_pkey PRIMARY KEY (id);


--
-- Name: system_change_log system_change_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_change_log
    ADD CONSTRAINT system_change_log_pkey PRIMARY KEY (id);


--
-- Name: system_document_category system_document_category_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document_category
    ADD CONSTRAINT system_document_category_pkey PRIMARY KEY (id);


--
-- Name: system_document_group system_document_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document_group
    ADD CONSTRAINT system_document_group_pkey PRIMARY KEY (id);


--
-- Name: system_document system_document_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document
    ADD CONSTRAINT system_document_pkey PRIMARY KEY (id);


--
-- Name: system_document_user system_document_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document_user
    ADD CONSTRAINT system_document_user_pkey PRIMARY KEY (id);


--
-- Name: system_group system_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_group
    ADD CONSTRAINT system_group_pkey PRIMARY KEY (id);


--
-- Name: system_group_program system_group_program_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_group_program
    ADD CONSTRAINT system_group_program_pkey PRIMARY KEY (id);


--
-- Name: system_message system_message_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_message
    ADD CONSTRAINT system_message_pkey PRIMARY KEY (id);


--
-- Name: system_notification system_notification_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_notification
    ADD CONSTRAINT system_notification_pkey PRIMARY KEY (id);


--
-- Name: system_program system_program_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_program
    ADD CONSTRAINT system_program_pkey PRIMARY KEY (id);


--
-- Name: system_request_log system_request_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_request_log
    ADD CONSTRAINT system_request_log_pkey PRIMARY KEY (id);


--
-- Name: system_sql_log system_sql_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_sql_log
    ADD CONSTRAINT system_sql_log_pkey PRIMARY KEY (id);


--
-- Name: system_unit system_unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_unit
    ADD CONSTRAINT system_unit_pkey PRIMARY KEY (id);


--
-- Name: system_user_group system_user_group_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_group
    ADD CONSTRAINT system_user_group_pkey PRIMARY KEY (id);


--
-- Name: system_user system_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user
    ADD CONSTRAINT system_user_pkey PRIMARY KEY (id);


--
-- Name: system_user_program system_user_program_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_program
    ADD CONSTRAINT system_user_program_pkey PRIMARY KEY (id);


--
-- Name: system_user_unit system_user_unit_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_unit
    ADD CONSTRAINT system_user_unit_pkey PRIMARY KEY (id);


--
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id);


--
-- Name: usuario_prova usuario_prova_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_prova
    ADD CONSTRAINT usuario_prova_pkey PRIMARY KEY (id);


--
-- Name: sys_group_program_group_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_group_program_group_idx ON public.system_group_program USING btree (system_group_id);


--
-- Name: sys_group_program_program_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_group_program_program_idx ON public.system_group_program USING btree (system_program_id);


--
-- Name: sys_user_group_group_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_user_group_group_idx ON public.system_user_group USING btree (system_group_id);


--
-- Name: sys_user_group_user_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_user_group_user_idx ON public.system_user_group USING btree (system_user_id);


--
-- Name: sys_user_program_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_user_program_idx ON public.system_user USING btree (frontpage_id);


--
-- Name: sys_user_program_program_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_user_program_program_idx ON public.system_user_program USING btree (system_program_id);


--
-- Name: sys_user_program_user_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sys_user_program_user_idx ON public.system_user_program USING btree (system_user_id);


--
-- Name: alternativa alternativa_questao_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa
    ADD CONSTRAINT alternativa_questao_id_fkey FOREIGN KEY (questao_id) REFERENCES public.questao(id);


--
-- Name: alternativa_resposta_questao alternativa_resposta_questao_alternativa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa_resposta_questao
    ADD CONSTRAINT alternativa_resposta_questao_alternativa_id_fkey FOREIGN KEY (alternativa_id) REFERENCES public.alternativa(id);


--
-- Name: alternativa_resposta_questao alternativa_resposta_questao_questao_usuario_prova_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.alternativa_resposta_questao
    ADD CONSTRAINT alternativa_resposta_questao_questao_usuario_prova_id_fkey FOREIGN KEY (questao_usuario_prova_id) REFERENCES public.questao_usuario_prova(id);


--
-- Name: grupo_prova grupo_prova_grupo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_prova
    ADD CONSTRAINT grupo_prova_grupo_id_fkey FOREIGN KEY (grupo_id) REFERENCES public.grupo(id);


--
-- Name: grupo_prova grupo_prova_prova_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_prova
    ADD CONSTRAINT grupo_prova_prova_id_fkey FOREIGN KEY (prova_id) REFERENCES public.prova(id);


--
-- Name: grupo_usuario grupo_usuario_grupo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_usuario
    ADD CONSTRAINT grupo_usuario_grupo_id_fkey FOREIGN KEY (grupo_id) REFERENCES public.grupo(id);


--
-- Name: grupo_usuario grupo_usuario_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.grupo_usuario
    ADD CONSTRAINT grupo_usuario_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuario(id);


--
-- Name: prova prova_usuario_responsavel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.prova
    ADD CONSTRAINT prova_usuario_responsavel_fkey FOREIGN KEY (usuario_responsavel) REFERENCES public.usuario(id);


--
-- Name: questao questao_prova_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao
    ADD CONSTRAINT questao_prova_id_fkey FOREIGN KEY (prova_id) REFERENCES public.prova(id);


--
-- Name: questao_usuario_prova questao_usuario_prova_questao_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao_usuario_prova
    ADD CONSTRAINT questao_usuario_prova_questao_id_fkey FOREIGN KEY (questao_id) REFERENCES public.questao(id);


--
-- Name: questao_usuario_prova questao_usuario_prova_usuario_prova_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questao_usuario_prova
    ADD CONSTRAINT questao_usuario_prova_usuario_prova_id_fkey FOREIGN KEY (usuario_prova_id) REFERENCES public.usuario_prova(id);


--
-- Name: resposta resposta_questao_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.resposta
    ADD CONSTRAINT resposta_questao_id_fkey FOREIGN KEY (questao_id) REFERENCES public.questao(id);


--
-- Name: system_document system_document_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document
    ADD CONSTRAINT system_document_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.system_document_category(id);


--
-- Name: system_document_group system_document_group_document_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document_group
    ADD CONSTRAINT system_document_group_document_id_fkey FOREIGN KEY (document_id) REFERENCES public.system_document(id);


--
-- Name: system_document_user system_document_user_document_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_document_user
    ADD CONSTRAINT system_document_user_document_id_fkey FOREIGN KEY (document_id) REFERENCES public.system_document(id);


--
-- Name: system_group_program system_group_program_system_group_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_group_program
    ADD CONSTRAINT system_group_program_system_group_id_fkey FOREIGN KEY (system_group_id) REFERENCES public.system_group(id);


--
-- Name: system_group_program system_group_program_system_program_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_group_program
    ADD CONSTRAINT system_group_program_system_program_id_fkey FOREIGN KEY (system_program_id) REFERENCES public.system_program(id);


--
-- Name: system_user system_user_frontpage_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user
    ADD CONSTRAINT system_user_frontpage_id_fkey FOREIGN KEY (frontpage_id) REFERENCES public.system_program(id);


--
-- Name: system_user_group system_user_group_system_group_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_group
    ADD CONSTRAINT system_user_group_system_group_id_fkey FOREIGN KEY (system_group_id) REFERENCES public.system_group(id);


--
-- Name: system_user_group system_user_group_system_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_group
    ADD CONSTRAINT system_user_group_system_user_id_fkey FOREIGN KEY (system_user_id) REFERENCES public.system_user(id);


--
-- Name: system_user_program system_user_program_system_program_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_program
    ADD CONSTRAINT system_user_program_system_program_id_fkey FOREIGN KEY (system_program_id) REFERENCES public.system_program(id);


--
-- Name: system_user_program system_user_program_system_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_program
    ADD CONSTRAINT system_user_program_system_user_id_fkey FOREIGN KEY (system_user_id) REFERENCES public.system_user(id);


--
-- Name: system_user system_user_system_unit_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user
    ADD CONSTRAINT system_user_system_unit_id_fkey FOREIGN KEY (system_unit_id) REFERENCES public.system_unit(id);


--
-- Name: system_user_unit system_user_unit_system_unit_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_unit
    ADD CONSTRAINT system_user_unit_system_unit_id_fkey FOREIGN KEY (system_unit_id) REFERENCES public.system_unit(id);


--
-- Name: system_user_unit system_user_unit_system_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.system_user_unit
    ADD CONSTRAINT system_user_unit_system_user_id_fkey FOREIGN KEY (system_user_id) REFERENCES public.system_user(id);


--
-- Name: usuario_prova usuario_prova_prova_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_prova
    ADD CONSTRAINT usuario_prova_prova_id_fkey FOREIGN KEY (prova_id) REFERENCES public.prova(id);


--
-- Name: usuario_prova usuario_prova_usuario_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario_prova
    ADD CONSTRAINT usuario_prova_usuario_id_fkey FOREIGN KEY (usuario_id) REFERENCES public.usuario(id);


--
-- PostgreSQL database dump complete
--

