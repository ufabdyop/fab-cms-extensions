--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: coralutah; Type: SCHEMA; Schema: -; Owner: coraldba
--

CREATE SCHEMA coralutah;


ALTER SCHEMA coralutah OWNER TO coraldba;

SET search_path = coralutah, pg_catalog;

--
-- Name: billing_code_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE billing_code_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.billing_code_id_seq OWNER TO coraldba;

--
-- Name: billing_code_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('billing_code_id_seq', 3, true);


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: billing_code; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE billing_code (
    id integer DEFAULT nextval('billing_code_id_seq'::regclass) NOT NULL,
    code character varying(255)
);


ALTER TABLE coralutah.billing_code OWNER TO coraldba;

--
-- Name: category_html; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE category_html (
    category character varying(255) NOT NULL,
    html text,
    modified timestamp without time zone
);


ALTER TABLE coralutah.category_html OWNER TO coraldba;

--
-- Name: device_hal_info; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE device_hal_info (
    device_name character varying(255) NOT NULL,
    parent character varying(255) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE coralutah.device_hal_info OWNER TO coraldba;

--
-- Name: door_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE door_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.door_id_seq OWNER TO coraldba;

--
-- Name: door_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('door_id_seq', 11, true);


--
-- Name: door; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE door (
    id integer DEFAULT nextval('door_id_seq'::regclass) NOT NULL,
    name character varying(255),
    entry_to integer,
    device character varying(255),
    relay integer,
    billing character varying,
    exit_from integer,
    type integer
);


ALTER TABLE coralutah.door OWNER TO coraldba;

--
-- Name: door_backup_2012_02_17; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE door_backup_2012_02_17 (
    id integer DEFAULT nextval('door_id_seq'::regclass) NOT NULL,
    name character varying(255),
    entry_to integer,
    device character varying(255),
    relay integer,
    billing character varying,
    exit_from integer,
    type integer
);


ALTER TABLE coralutah.door_backup_2012_02_17 OWNER TO coraldba;

--
-- Name: door_types_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE door_types_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.door_types_id_seq OWNER TO coraldba;

--
-- Name: door_types_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('door_types_id_seq', 3, true);


--
-- Name: door_types; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE door_types (
    id integer DEFAULT nextval('door_types_id_seq'::regclass) NOT NULL,
    type character varying(255)
);


ALTER TABLE coralutah.door_types OWNER TO coraldba;

--
-- Name: equipment_chemical; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_chemical (
    item character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    active boolean,
    role_required character varying(255)
);


ALTER TABLE coralutah.equipment_chemical OWNER TO coraldba;

--
-- Name: equipment_extended; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_extended (
    item character varying(255) NOT NULL,
    html text,
    image_url character varying(255),
    reports_url character varying(255),
    display_on_web boolean,
    modified timestamp without time zone DEFAULT now(),
    current_url character varying(255),
    di_water boolean,
    data_gathered boolean,
    billing_rate double precision,
    map_id smallint,
    summary text,
    move_date date,
    move_date_type character varying(255),
    move_edate date
);


ALTER TABLE coralutah.equipment_extended OWNER TO coraldba;

--
-- Name: equipment_extended_backup_2012_04_16; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_extended_backup_2012_04_16 (
    item character varying(255) NOT NULL,
    html text,
    image_url character varying(255),
    reports_url character varying(255),
    display_on_web boolean,
    modified timestamp without time zone DEFAULT now(),
    current_url character varying(255),
    di_water boolean,
    data_gathered boolean,
    billing_rate double precision,
    map_id smallint,
    summary text,
    move_date date,
    move_date_type character varying(255),
    move_edate date
);


ALTER TABLE coralutah.equipment_extended_backup_2012_04_16 OWNER TO coraldba;

--
-- Name: equipment_extended_broken; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_extended_broken (
    item character varying(255) NOT NULL,
    html text,
    image_url character varying(255),
    reports_url character varying(255),
    display_on_web boolean,
    modified timestamp without time zone DEFAULT now(),
    current_url character varying(255),
    di_water boolean,
    data_gathered boolean,
    billing_rate double precision
);


ALTER TABLE coralutah.equipment_extended_broken OWNER TO coraldba;

--
-- Name: equipment_manual; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_manual (
    item character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    active boolean,
    role_required character varying(255)
);


ALTER TABLE coralutah.equipment_manual OWNER TO coraldba;

--
-- Name: equipment_maps; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_maps (
    filename character varying(255),
    description character varying(255),
    id integer NOT NULL,
    width integer,
    height integer
);


ALTER TABLE coralutah.equipment_maps OWNER TO coraldba;

--
-- Name: equipment_maps_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE equipment_maps_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.equipment_maps_id_seq OWNER TO coraldba;

--
-- Name: equipment_maps_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE equipment_maps_id_seq OWNED BY equipment_maps.id;


--
-- Name: equipment_maps_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('equipment_maps_id_seq', 1, true);


--
-- Name: equipment_owner; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_owner (
    item character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    active boolean,
    role_required character varying(255)
);


ALTER TABLE coralutah.equipment_owner OWNER TO coraldba;

--
-- Name: equipment_software; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_software (
    item character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    active boolean,
    role_required character varying(255)
);


ALTER TABLE coralutah.equipment_software OWNER TO coraldba;

--
-- Name: equipment_sop; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE equipment_sop (
    item character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    active boolean,
    role_required character varying(255),
    description character varying(255)
);


ALTER TABLE coralutah.equipment_sop OWNER TO coraldba;

--
-- Name: export_log; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE export_log (
    user_type "unknown",
    project text,
    project_number character varying(200),
    last_name character varying(255),
    first_name character varying(255),
    date timestamp without time zone,
    time_in timestamp without time zone,
    time_out timestamp without time zone,
    time_total double precision,
    microfab double precision,
    ssl double precision,
    teaching double precision,
    billing_code text,
    comment text,
    device character varying(255),
    pi character varying(200),
    errors text
);


ALTER TABLE coralutah.export_log OWNER TO coraldba;

--
-- Name: holidays; Type: TABLE; Schema: coralutah; Owner: postgres; Tablespace: 
--

CREATE TABLE holidays (
    id integer NOT NULL,
    date date,
    name character varying(255)
);


ALTER TABLE coralutah.holidays OWNER TO postgres;

--
-- Name: holidays_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: postgres
--

CREATE SEQUENCE holidays_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.holidays_id_seq OWNER TO postgres;

--
-- Name: holidays_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: postgres
--

SELECT pg_catalog.setval('holidays_id_seq', 1, false);


--
-- Name: log; Type: TABLE; Schema: coralutah; Owner: postgres; Tablespace: 
--

CREATE TABLE log (
    id integer NOT NULL,
    card_id character varying(16) NOT NULL,
    member character varying(200) NOT NULL,
    user_type character varying(255),
    project text,
    project_number text,
    last_name character varying(255),
    first_name character varying(255),
    time_in timestamp without time zone,
    time_out timestamp without time zone,
    time_total double precision,
    time_total_non_overlap double precision,
    microfab double precision,
    ssl double precision,
    teaching double precision,
    billing_code text,
    comment text,
    device character varying(255),
    pi text,
    errors text,
    no_swipe_in boolean,
    no_swipe_out boolean,
    violation boolean,
    swipe_in_door integer,
    swipe_out_door integer,
    is_active boolean,
    penalty double precision,
    is_adjustment boolean
);


ALTER TABLE coralutah.log OWNER TO postgres;

--
-- Name: log_adjustments; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE log_adjustments (
    id integer NOT NULL,
    card_id character varying(16) NOT NULL,
    member character varying(200) NOT NULL,
    user_type character varying(255),
    project text NOT NULL,
    project_number text,
    last_name character varying(255),
    first_name character varying(255),
    time_in timestamp without time zone,
    time_out timestamp without time zone,
    time_total double precision,
    time_total_non_overlap double precision,
    microfab double precision,
    ssl double precision,
    teaching double precision,
    billing_code text,
    comment text,
    device character varying(255),
    pi text,
    errors text,
    no_swipe_in boolean,
    no_swipe_out boolean,
    violation boolean,
    swipe_in_door integer,
    swipe_out_door integer,
    is_active boolean,
    penalty double precision,
    original_id integer,
    last_modified timestamp(6) without time zone DEFAULT now(),
    modified_by character varying(255),
    version_number integer,
    active_version boolean
);


ALTER TABLE coralutah.log_adjustments OWNER TO coraldba;

--
-- Name: log_adjustments_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE log_adjustments_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.log_adjustments_id_seq OWNER TO coraldba;

--
-- Name: log_adjustments_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE log_adjustments_id_seq OWNED BY log_adjustments.id;


--
-- Name: log_adjustments_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('log_adjustments_id_seq', 27, true);


--
-- Name: log_adjustments_version_number_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE log_adjustments_version_number_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.log_adjustments_version_number_seq OWNER TO coraldba;

--
-- Name: log_adjustments_version_number_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE log_adjustments_version_number_seq OWNED BY log_adjustments.version_number;


--
-- Name: log_adjustments_version_number_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('log_adjustments_version_number_seq', 37, true);


--
-- Name: log_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: postgres
--

CREATE SEQUENCE log_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.log_id_seq OWNER TO postgres;

--
-- Name: log_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: postgres
--

ALTER SEQUENCE log_id_seq OWNED BY log.id;


--
-- Name: log_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: postgres
--

SELECT pg_catalog.setval('log_id_seq', 320, true);


--
-- Name: member_extended_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE member_extended_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.member_extended_id_seq OWNER TO coraldba;

--
-- Name: member_extended_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('member_extended_id_seq', 782, true);


--
-- Name: member_extended; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE member_extended (
    id integer DEFAULT nextval('member_extended_id_seq'::regclass) NOT NULL,
    member character varying(200),
    locked boolean,
    card_id character varying(16),
    expiration timestamp without time zone,
    company character varying(200),
    comment_1 character varying(200),
    comment_2 character varying(200),
    emergency_contact_name character varying(200),
    emergency_contact_phone_number character varying(200),
    safety boolean,
    reason_locked character varying(200),
    last_error character varying(200),
    prox_id character varying(10)
);


ALTER TABLE coralutah.member_extended OWNER TO coraldba;

--
-- Name: pi_report; Type: VIEW; Schema: coralutah; Owner: coraldba
--

CREATE VIEW pi_report AS
    SELECT a.member, a.amount, a.item, a.account, p.pi, m.lastname, m.firstname, m.name, a.bdate, a.edate FROM ((eqmgr.eq_activity a LEFT JOIN rscmgr.project p ON (((a.project)::text = (p.name)::text))) LEFT JOIN rscmgr.member m ON (((m.name)::text = (a.member)::text)));


ALTER TABLE coralutah.pi_report OWNER TO coraldba;

--
-- Name: reservations_from_legacy_system; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE reservations_from_legacy_system (
    user_type character varying(255),
    project character varying(255),
    project_number character varying(255),
    last_name character varying(255),
    first_name character varying(255),
    date timestamp without time zone,
    time_in timestamp without time zone,
    time_out timestamp without time zone,
    time_total double precision,
    microfab double precision,
    ssl double precision,
    teaching double precision,
    billing_code character varying(255),
    comment text,
    device character varying(255),
    pi character varying(255),
    errors character varying(200)
);


ALTER TABLE coralutah.reservations_from_legacy_system OWNER TO coraldba;

--
-- Name: room_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE room_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.room_id_seq OWNER TO coraldba;

--
-- Name: room_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('room_id_seq', 6, true);


--
-- Name: room; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE room (
    id integer DEFAULT nextval('room_id_seq'::regclass) NOT NULL,
    name character varying(255)
);


ALTER TABLE coralutah.room OWNER TO coraldba;

SET default_with_oids = true;

--
-- Name: sensor; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE sensor (
    coralid integer NOT NULL,
    name character varying(200),
    lab character varying(200),
    type character varying(200),
    facility character varying(200),
    sunspotaddress character(19),
    sensorid integer NOT NULL,
    units character varying(200),
    minimum double precision NOT NULL,
    maximum double precision NOT NULL,
    lowalarm double precision NOT NULL,
    highalarm double precision NOT NULL,
    active integer NOT NULL,
    bdate timestamp without time zone,
    edate timestamp without time zone
);


ALTER TABLE coralutah.sensor OWNER TO coraldba;

--
-- Name: sensor_coralid_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE sensor_coralid_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.sensor_coralid_seq OWNER TO coraldba;

--
-- Name: sensor_coralid_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE sensor_coralid_seq OWNED BY sensor.coralid;


--
-- Name: sensor_coralid_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('sensor_coralid_seq', 1, false);


--
-- Name: sensor_data; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE sensor_data (
    id integer NOT NULL,
    sunspotaddress character(19),
    sensorid integer,
    tstamp timestamp without time zone,
    rawvalue integer,
    computedvalue double precision,
    firstderivative double precision,
    secondderivative double precision,
    machine character varying(255)
);


ALTER TABLE coralutah.sensor_data OWNER TO coraldba;

--
-- Name: sensor_data_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE sensor_data_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.sensor_data_id_seq OWNER TO coraldba;

--
-- Name: sensor_data_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE sensor_data_id_seq OWNED BY sensor_data.id;


--
-- Name: sensor_data_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('sensor_data_id_seq', 717787, true);


--
-- Name: simple_log; Type: TABLE; Schema: coralutah; Owner: postgres; Tablespace: 
--

CREATE TABLE simple_log (
    id integer NOT NULL,
    date date,
    "time" time without time zone,
    card_id character varying(20),
    device_name character varying(40),
    log_1 character varying(100),
    log_2 character varying(100),
    log_3 character varying(100),
    "timestamp" timestamp without time zone DEFAULT now(),
    member character varying(255)
);


ALTER TABLE coralutah.simple_log OWNER TO postgres;

--
-- Name: simple_log_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: postgres
--

CREATE SEQUENCE simple_log_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.simple_log_id_seq OWNER TO postgres;

--
-- Name: simple_log_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: postgres
--

ALTER SEQUENCE simple_log_id_seq OWNED BY simple_log.id;


--
-- Name: simple_log_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: postgres
--

SELECT pg_catalog.setval('simple_log_id_seq', 858, true);


SET default_with_oids = false;

--
-- Name: usb_info_for_doors; Type: TABLE; Schema: coralutah; Owner: coraldba; Tablespace: 
--

CREATE TABLE usb_info_for_doors (
    id integer NOT NULL,
    dev_name character varying(255),
    device character varying(255),
    parent character varying(255),
    grandpa character varying(255),
    door character varying(255)
);


ALTER TABLE coralutah.usb_info_for_doors OWNER TO coraldba;

--
-- Name: TABLE usb_info_for_doors; Type: COMMENT; Schema: coralutah; Owner: coraldba
--

COMMENT ON TABLE usb_info_for_doors IS 'These data were gathered from the following shell script:

#!/bin/sh 

for udi in `hal-find-by-capability --capability serial | sort`
do
        parent=`hal-get-property --udi ${udi} --key "info.parent"`
        device=`hal-get-property --udi ${udi} --key "linux.device_file"`
        vendor=`hal-get-property --udi ${parent} --key "usb.vendor_id"`
        product=`hal-get-property --udi ${parent} --key "usb.product_id"`
        driver=`hal-get-property --udi ${parent} --key "info.linux.driver"`
        bus=`hal-get-property --udi ${parent} --key "usb.bus_number"`
        interf=`hal-get-property --udi ${parent} --key "usb.interface.number"`
        grandpa=`hal-get-property --udi ${parent} --key "info.parent"`
        name=`hal-get-property --udi ${grandpa} --key "info.product"`
        echo -------DEVICE-----------
        echo name: $name
        echo device: $device
        echo parent: $parent
        echo grandpa: $grandpa
done
';


--
-- Name: usb_info_for_doors_id_seq; Type: SEQUENCE; Schema: coralutah; Owner: coraldba
--

CREATE SEQUENCE usb_info_for_doors_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE coralutah.usb_info_for_doors_id_seq OWNER TO coraldba;

--
-- Name: usb_info_for_doors_id_seq; Type: SEQUENCE OWNED BY; Schema: coralutah; Owner: coraldba
--

ALTER SEQUENCE usb_info_for_doors_id_seq OWNED BY usb_info_for_doors.id;


--
-- Name: usb_info_for_doors_id_seq; Type: SEQUENCE SET; Schema: coralutah; Owner: coraldba
--

SELECT pg_catalog.setval('usb_info_for_doors_id_seq', 9, true);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE equipment_maps ALTER COLUMN id SET DEFAULT nextval('equipment_maps_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: postgres
--

ALTER TABLE log ALTER COLUMN id SET DEFAULT nextval('log_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE log_adjustments ALTER COLUMN id SET DEFAULT nextval('log_adjustments_id_seq'::regclass);


--
-- Name: version_number; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE log_adjustments ALTER COLUMN version_number SET DEFAULT nextval('log_adjustments_version_number_seq'::regclass);


--
-- Name: coralid; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE sensor ALTER COLUMN coralid SET DEFAULT nextval('sensor_coralid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE sensor_data ALTER COLUMN id SET DEFAULT nextval('sensor_data_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: postgres
--

ALTER TABLE simple_log ALTER COLUMN id SET DEFAULT nextval('simple_log_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: coralutah; Owner: coraldba
--

ALTER TABLE usb_info_for_doors ALTER COLUMN id SET DEFAULT nextval('usb_info_for_doors_id_seq'::regclass);


--
-- Data for Name: billing_code; Type: TABLE DATA; Schema: coralutah; Owner: coraldba
--



--
-- Data for Name: category_html; Type: TABLE DATA; Schema: coralutah; Owner: coraldba
--


--
-- PostgreSQL database dump complete
--

