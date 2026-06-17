from __future__ import annotations

from django.db import models

from apps.common.models import BaseModel


class ConsultationThread(BaseModel):
    STATUS_CHOICES = [
        ("OPEN", "Open"),
        ("CLOSED", "Closed"),
    ]

    guru = models.ForeignKey(
        "master.GuruBinaan",
        on_delete=models.CASCADE,
        related_name="consultation_threads",
    )
    periode = models.ForeignKey(
        "master.PeriodeTriwulan",
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name="consultation_threads",
    )
    subject = models.CharField(max_length=255)
    status = models.CharField(max_length=20, choices=STATUS_CHOICES, default="OPEN", db_index=True)
    last_message_at = models.DateTimeField(null=True, blank=True)

    class Meta:
        ordering = ["-last_message_at", "-created_at"]

    def __str__(self) -> str:
        return self.subject


class ConsultationMessage(BaseModel):
    thread = models.ForeignKey(
        "konsultasi.ConsultationThread",
        on_delete=models.CASCADE,
        related_name="messages",
    )
    sender = models.ForeignKey(
        "accounts.CustomUser",
        on_delete=models.CASCADE,
        related_name="consultation_messages",
    )
    message = models.TextField()
    attachment = models.FileField(upload_to="konsultasi/attachments/", blank=True, null=True)
    is_read = models.BooleanField(default=False, db_index=True)

    class Meta:
        ordering = ["created_at"]

    def __str__(self) -> str:
        return f"{self.sender} - {self.thread}"