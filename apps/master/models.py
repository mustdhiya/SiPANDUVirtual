from __future__ import annotations

from django.conf import settings
from django.db import models
from django.utils.text import slugify

from apps.common.models import BaseModel


class TahunAjaran(BaseModel):
    label = models.CharField(max_length=20, unique=True)
    is_active = models.BooleanField(default=False, db_index=True)
    start_date = models.DateField(null=True, blank=True)
    end_date = models.DateField(null=True, blank=True)

    class Meta:
        ordering = ["-created_at"]

    def __str__(self) -> str:
        return self.label


class PeriodeTriwulan(BaseModel):
    NOMOR_CHOICES = [
        (1, "Triwulan I — Perencanaan & Pemetaan"),
        (2, "Triwulan II — Pendampingan Tahap Awal"),
        (3, "Triwulan III — Observasi & Umpan Balik"),
        (4, "Triwulan IV — Evaluasi & Pelaporan"),
    ]

    tahun_ajaran = models.ForeignKey(
        "master.TahunAjaran",
        on_delete=models.CASCADE,
        related_name="periodes",
        null=True,
        blank=True,
    )
    nomor = models.PositiveSmallIntegerField(choices=NOMOR_CHOICES)
    tema = models.CharField(max_length=255)
    description = models.TextField(blank=True)
    deadline = models.DateField()
    is_open = models.BooleanField(default=False, db_index=True)

    class Meta:
        unique_together = ("tahun_ajaran", "nomor")
        ordering = ["tahun_ajaran__label", "nomor"]

    def __str__(self) -> str:
        if self.tahun_ajaran:
            return f"{self.tahun_ajaran.label} - TW {self.nomor}"
        return f"TW {self.nomor}"


class SekolahBinaan(BaseModel):
    JENJANG_CHOICES = [
        ("SMA", "SMA"),
        ("SMK", "SMK"),
    ]
    STATUS_CHOICES = [
        ("N", "Negeri"),
        ("S", "Swasta"),
    ]

    nama_sekolah = models.CharField(max_length=255, unique=True)
    slug = models.SlugField(max_length=280, unique=True, blank=True)
    jenjang = models.CharField(max_length=10, choices=JENJANG_CHOICES, db_index=True)
    status = models.CharField(max_length=1, choices=STATUS_CHOICES, db_index=True)
    npsn = models.CharField(max_length=20, blank=True)
    alamat = models.TextField(blank=True)
    is_active = models.BooleanField(default=True, db_index=True)

    class Meta:
        ordering = ["nama_sekolah"]

    def save(self, *args, **kwargs):
        if not self.slug:
            self.slug = slugify(self.nama_sekolah)
        super().save(*args, **kwargs)

    def __str__(self) -> str:
        return self.nama_sekolah


class GuruBinaan(BaseModel):
    user_account = models.OneToOneField(
        settings.AUTH_USER_MODEL,
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="guru_profile",
    )
    tahun_ajaran = models.ForeignKey(
        "master.TahunAjaran",
        on_delete=models.CASCADE,
        related_name="guru_binaan",
        null=True,
        blank=True,
    )
    sekolah = models.ForeignKey(
        "master.SekolahBinaan",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="gurus",
    )
    nama_lengkap = models.CharField(max_length=255)
    nip = models.CharField(max_length=30, blank=True)
    nik = models.CharField(max_length=30, blank=True)
    nip_siaga = models.CharField(max_length=50, db_index=True)
    akun_siaga = models.CharField(max_length=100, blank=True)
    satminkal = models.CharField(max_length=255, blank=True)
    golongan = models.CharField(max_length=50, blank=True)
    nomor_wa = models.CharField(max_length=20, blank=True)
    status_sertifikasi = models.BooleanField(default=False)
    is_active = models.BooleanField(default=True, db_index=True)

    class Meta:
        ordering = ["nama_lengkap"]
        indexes = [
            models.Index(fields=["tahun_ajaran", "sekolah"]),
            models.Index(fields=["tahun_ajaran", "is_active"]),
        ]

    def __str__(self) -> str:
        return self.nama_lengkap


class InstrumentQuestion(BaseModel):
    QUESTION_TYPE_CHOICES = [
        ("PILIHAN", "Pilihan A/B/C/D"),
        ("TEXT", "Text"),
        ("NUMBER", "Number"),
        ("BOOLEAN", "Boolean"),
    ]

    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="questions",
    )
    code = models.CharField(max_length=10)
    label = models.TextField()
    question_type = models.CharField(max_length=20, choices=QUESTION_TYPE_CHOICES, default="PILIHAN")
    is_required = models.BooleanField(default=True)
    sort_order = models.PositiveIntegerField(default=0)

    class Meta:
        unique_together = ("periode", "code")
        ordering = ["sort_order", "code"]

    def __str__(self) -> str:
        return f"{self.code} - {self.periode}"


class RequiredDocumentType(BaseModel):
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.CASCADE,
        related_name="required_document_types",
    )
    code = models.CharField(max_length=10)
    name = models.CharField(max_length=255)
    description = models.TextField(blank=True)
    allowed_extensions = models.CharField(
        max_length=255,
        blank=True,
        help_text="Contoh: pdf,jpg,png,zip",
    )
    max_size_mb = models.PositiveIntegerField(default=10)
    is_required = models.BooleanField(default=True)
    sort_order = models.PositiveIntegerField(default=0)

    class Meta:
        unique_together = ("periode", "code")
        ordering = ["sort_order", "code"]

    def __str__(self) -> str:
        return f"{self.code} - {self.name}"