from django.contrib import admin

from apps.master.models import GuruBinaan, PeriodeTriwulan, SekolahBinaan, TahunAjaran


@admin.register(TahunAjaran)
class TahunAjaranAdmin(admin.ModelAdmin):
    list_display = ("label", "is_active", "created_at")
    list_filter = ("is_active",)
    search_fields = ("label",)


@admin.register(PeriodeTriwulan)
class PeriodeTriwulanAdmin(admin.ModelAdmin):
    list_display = ("tahun_ajaran", "nomor", "tema", "deadline", "is_open")
    list_filter = ("nomor", "is_open", "tahun_ajaran")
    search_fields = ("tema",)


@admin.register(SekolahBinaan)
class SekolahBinaanAdmin(admin.ModelAdmin):
    list_display = ("nama_sekolah", "jenjang", "status", "is_active")
    list_filter = ("jenjang", "status", "is_active")
    search_fields = ("nama_sekolah",)


@admin.register(GuruBinaan)
class GuruBinaanAdmin(admin.ModelAdmin):
    list_display = ("nama_lengkap", "sekolah", "nip_siaga", "is_active")
    list_filter = ("is_active", "sekolah")
    search_fields = ("nama_lengkap", "nip_siaga")