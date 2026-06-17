from __future__ import annotations

from django.db import models

from apps.common.models import BaseModel


class MateriKategori(BaseModel):
    name = models.CharField(max_length=100, unique=True)
    description = models.TextField(blank=True)
    is_active = models.BooleanField(default=True, db_index=True)

    class Meta:
        ordering = ["name"]

    def __str__(self) -> str:
        return self.name


class MateriGudang(BaseModel):
    kategori = models.ForeignKey(
        "gudang.MateriKategori",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="materi_items",
    )
    title = models.CharField(max_length=255)
    description = models.TextField(blank=True)
    file = models.FileField(upload_to="gudang/materi/")
    thumbnail = models.ImageField(upload_to="gudang/thumbnails/", blank=True, null=True)
    is_published = models.BooleanField(default=True, db_index=True)
    published_at = models.DateTimeField(null=True, blank=True)
    download_count = models.PositiveIntegerField(default=0)

    class Meta:
        ordering = ["-created_at"]
        indexes = [
            models.Index(fields=["is_published"]),
        ]

    def __str__(self) -> str:
        return self.title