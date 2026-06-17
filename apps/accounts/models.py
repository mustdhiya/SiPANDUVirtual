from __future__ import annotations

from django.contrib.auth.models import AbstractUser
from django.db import models

from apps.common.choices import (
    ACCOUNT_STATUS_ACTIVE,
    ACCOUNT_STATUS_CHOICES,
    ACCOUNT_STATUS_PENDING,
    ROLE_CHOICES,
    ROLE_GURU,
)
from apps.common.models import TimeStampedModel


class CustomUser(AbstractUser):
    role = models.CharField(max_length=20, choices=ROLE_CHOICES, default=ROLE_GURU, db_index=True)
    status = models.CharField(
        max_length=20,
        choices=ACCOUNT_STATUS_CHOICES,
        default=ACCOUNT_STATUS_PENDING,
        db_index=True,
    )
    is_approved = models.BooleanField(default=False, db_index=True)
    nomor_wa = models.CharField(max_length=20, blank=True)
    photo = models.ImageField(upload_to="profile/photos/", blank=True, null=True)
    approval_note = models.TextField(blank=True)
    approved_at = models.DateTimeField(null=True, blank=True)
    rejected_at = models.DateTimeField(null=True, blank=True)

    def can_login(self) -> bool:
        return self.is_active and self.is_approved and self.status == ACCOUNT_STATUS_ACTIVE

    @property
    def is_admin_pengawas(self) -> bool:
        return self.role == "ADMIN"

    @property
    def is_guru(self) -> bool:
        return self.role == ROLE_GURU


class RegistrationRequest(TimeStampedModel):
    user = models.OneToOneField(
        "accounts.CustomUser",
        on_delete=models.CASCADE,
        related_name="registration_request",
    )
    nama_lengkap = models.CharField(max_length=255)
    nip_siaga = models.CharField(max_length=50, db_index=True)
    nomor_wa = models.CharField(max_length=20)
    foto_sk = models.FileField(upload_to="registrasi/sk/")
    matched_guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="registration_requests",
    )
    is_matched = models.BooleanField(default=False, db_index=True)
    admin_note = models.TextField(blank=True)

    class Meta:
        ordering = ["-created_at"]

    def __str__(self) -> str:
        return f"{self.nama_lengkap} - {self.nip_siaga}"