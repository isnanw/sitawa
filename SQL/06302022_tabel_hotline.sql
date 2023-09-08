CREATE TABLE public.hotline (
  id INTEGER,
  urai VARCHAR(100),
  keterangan VARCHAR(100);
  link VARCHAR(100),
  icon VARCHAR(25),
  PRIMARY KEY(id)
)
WITH (oids = false);

-- Auto Icremen
CREATE SEQUENCE sequence_id_hotline;
ALTER TABLE hotline ALTER COLUMN id SET DEFAULT NEXTVAL('sequence_id_hotline');