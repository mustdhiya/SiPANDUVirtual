from apps.audit.models import AuditLog


class AuditRequestMiddleware:
    def __init__(self, get_response):
        self.get_response = get_response

    def __call__(self, request):
        response = self.get_response(request)

        if request.user.is_authenticated and request.method in {"POST", "PUT", "PATCH", "DELETE"}:
            x_forwarded_for = request.META.get("HTTP_X_FORWARDED_FOR")
            ip_address = x_forwarded_for.split(",")[0].strip() if x_forwarded_for else request.META.get("REMOTE_ADDR")

            AuditLog.objects.create(
                user=request.user,
                method=request.method,
                path=request.path[:255],
                ip_address=ip_address,
                user_agent=request.META.get("HTTP_USER_AGENT", "")[:1000],
            )

        return response