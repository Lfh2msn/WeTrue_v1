--
-- PostgreSQL database dump
--

-- Dumped from database version 13.0 (Debian 13.0-1.pgdg100+1)
-- Dumped by pg_dump version 13.0 (Debian 13.0-1.pgdg100+1)

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
-- Name: wet_behavior_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_behavior_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_behavior_UID_seq" OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: wet_behavior; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_behavior (
    uid integer DEFAULT nextval('public."wet_behavior_UID_seq"'::regclass) NOT NULL,
    address character varying(60),
    hash character varying(60),
    thing text,
    influence text,
    toaddress character varying(60),
    utctime timestamp with time zone DEFAULT now()
);


ALTER TABLE public.wet_behavior OWNER TO postgres;

--
-- Name: wet_bloom_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_bloom_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_bloom_UID_seq" OWNER TO postgres;

--
-- Name: wet_bloom; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_bloom (
    uid bigint DEFAULT nextval('public."wet_bloom_UID_seq"'::regclass) NOT NULL,
    bf_hash character varying(60),
    bf_address character varying(60),
    bf_ip cidr,
    bf_reason text,
    bf_time timestamp without time zone DEFAULT now()
);


ALTER TABLE public.wet_bloom OWNER TO postgres;

--
-- Name: wet_comment_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_comment_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_comment_UID_seq" OWNER TO postgres;

--
-- Name: wet_comment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_comment (
    uid integer DEFAULT nextval('public."wet_comment_UID_seq"'::regclass) NOT NULL,
    hash character varying(60),
    to_hash character varying(60),
    sender_id character varying(60),
    recipient_id character varying(60),
    utctime numeric(20,0),
    amount numeric(30,0),
    content_type character varying(20),
    payload text,
    imgtx text,
    love numeric(5,0) DEFAULT 0,
    commsum integer DEFAULT 0
);


ALTER TABLE public.wet_comment OWNER TO postgres;

--
-- Name: wet_content_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_content_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_content_UID_seq" OWNER TO postgres;

--
-- Name: wet_content; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_content (
    uid integer DEFAULT nextval('public."wet_content_UID_seq"'::regclass) NOT NULL,
    hash character varying(60),
    sender_id character varying(60),
    recipient_id character varying(60),
    utctime numeric(20,0),
    amount numeric(30,0),
    content_type character varying(20),
    payload text,
    imgtx text,
    love integer DEFAULT 0,
    commsum integer DEFAULT 0
);


ALTER TABLE public.wet_content OWNER TO postgres;

--
-- Name: wet_follow_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_follow_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_follow_UID_seq" OWNER TO postgres;

--
-- Name: wet_follow; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_follow (
    uid bigint DEFAULT nextval('public."wet_follow_UID_seq"'::regclass) NOT NULL,
    following character varying(60),
    followers character varying(60),
    follow_time timestamp without time zone DEFAULT now()
);


ALTER TABLE public.wet_follow OWNER TO postgres;

--
-- Name: wet_love_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_love_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_love_UID_seq" OWNER TO postgres;

--
-- Name: wet_love; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_love (
    uid integer DEFAULT nextval('public."wet_love_UID_seq"'::regclass) NOT NULL,
    hash character varying(60),
    sender_id character varying(60),
    live_time timestamp without time zone DEFAULT now()
);


ALTER TABLE public.wet_love OWNER TO postgres;

--
-- Name: wet_report_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_report_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_report_UID_seq" OWNER TO postgres;

--
-- Name: wet_report; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_report (
    uid bigint DEFAULT nextval('public."wet_report_UID_seq"'::regclass) NOT NULL,
    rp_hash character varying(60),
    rp_sender_id character varying(60),
    rp_time timestamp without time zone DEFAULT now(),
    rp_count numeric(5,0) DEFAULT 0 NOT NULL
);


ALTER TABLE public.wet_report OWNER TO postgres;

--
-- Name: wet_temporary_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_temporary_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_temporary_UID_seq" OWNER TO postgres;

--
-- Name: wet_temporary; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_temporary (
    uid bigint DEFAULT nextval('public."wet_temporary_UID_seq"'::regclass) NOT NULL,
    tp_hash character varying(60),
    tp_source text,
    tp_time timestamp without time zone DEFAULT now()
);


ALTER TABLE public.wet_temporary OWNER TO postgres;

--
-- Name: wet_users_UID_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public."wet_users_UID_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public."wet_users_UID_seq" OWNER TO postgres;

--
-- Name: wet_users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wet_users (
    uid integer DEFAULT nextval('public."wet_users_UID_seq"'::regclass) NOT NULL,
    address character varying(60),
    username character varying(30),
    uactive integer DEFAULT 0,
    portrait text,
    utctime timestamp without time zone DEFAULT now(),
    maxportrait character varying(60)
);


ALTER TABLE public.wet_users OWNER TO postgres;

--
-- Name: wet_comment wet_comment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wet_comment
    ADD CONSTRAINT wet_comment_pkey PRIMARY KEY (uid);


--
-- Name: wet_temporary wet_temporary_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wet_temporary
    ADD CONSTRAINT wet_temporary_pkey PRIMARY KEY (uid);


--
-- Name: wet_behavior wey_behavior_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wet_behavior
    ADD CONSTRAINT wey_behavior_pkey PRIMARY KEY (uid);


--
-- PostgreSQL database dump complete
--

