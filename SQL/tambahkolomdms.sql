-- Kolom nomer dokumen
ALTER TABLE public.dms
  ADD COLUMN no_dokumen VARCHAR(256);
-- Kolom tanggal dokumen
ALTER TABLE public.dms
  ADD COLUMN tanggal_dokumen DATE;

-- Tambah siapa yg upload, karena operator bisa membantu upload berkas pegawai
ALTER TABLE public.dms
  ADD COLUMN created VARCHAR(100);

-- Berkas tidak di hapus
ALTER TABLE public.dms
  ADD COLUMN is_delete BOOLEAN;

ALTER TABLE public.dms
  ALTER COLUMN is_delete SET DEFAULT FALSE;

