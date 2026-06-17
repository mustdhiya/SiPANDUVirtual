"""
URL configuration for config project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/6.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.conf import settings
from django.conf.urls.static import static
from django.contrib import admin
from django.urls import include, path
from django.views.generic import RedirectView

urlpatterns = [
    path("superadmin/", admin.site.urls),
    path("", RedirectView.as_view(pattern_name="dashboard:home", permanent=False), name="root"),
    path("accounts/", include(("apps.accounts.urls", "accounts"), namespace="accounts")),
    path("dashboard/", include(("apps.dashboard.urls", "dashboard"), namespace="dashboard")),
    path("dokumen/", include(("apps.dokumen.urls", "dokumen"), namespace="dokumen")),
    path("gudang/", include(("apps.gudang.urls", "gudang"), namespace="gudang")),
    path("konsultasi/", include(("apps.konsultasi.urls", "konsultasi"), namespace="konsultasi")),
    path("master/", include(("apps.master.urls", "master"), namespace="master")),
    path("triwulan/", include(("apps.triwulan.urls", "triwulan"), namespace="triwulan")),
]

if settings.DEBUG:
    urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)