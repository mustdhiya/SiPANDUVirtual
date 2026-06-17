from django.contrib import admin

from apps.gudang.models import MateriGudang, MateriKategori


@admin.register(MateriKategori)
class MateriKategoriAdmin(admin.ModelAdmin):
    list_display = ("name", "is_active")
    list_filter = ("is_active",)
    search_fields = ("name",)


@admin.register(MateriGudang)
class MateriGudangAdmin(admin.ModelAdmin):
    list_display = ("title", "kategori", "is_published", "download_count", "published_at")
    list_filter = ("is_published", "kategori")
    search_fields = ("title",)