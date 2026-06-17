from django.contrib import admin
from django.contrib.auth.admin import UserAdmin

from apps.accounts.models import CustomUser


@admin.register(CustomUser)
class CustomUserAdmin(UserAdmin):
    fieldsets = UserAdmin.fieldsets + (
        ("SiPANDU", {"fields": ("nomor_wa", "is_approved", "status")}),
    )
    list_display = ("username", "email", "is_approved", "status", "is_staff")
    list_filter = ("is_approved", "status", "is_staff")