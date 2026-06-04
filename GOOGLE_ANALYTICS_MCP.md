# Google Analytics 4 and MCP

This project uses GA4 only when `GOOGLE_ANALYTICS_MEASUREMENT_ID` is configured in the production Laravel environment.

## Site tracking

1. Create or open the GA4 property for `ampleev.com`.
2. Create a Web data stream for `https://ampleev.com`.
3. Copy the Measurement ID. It has the format `G-XXXXXXXXXX`.
4. Add it to production `.env`:

```bash
GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
```

5. Clear Laravel config cache:

```bash
cd /var/www/ampleev.com/blog
php artisan optimize:clear
```

The existing `?metrika=off` browser toggle disables both Yandex Metrika and GA4 for that browser. Use `?metrika=on` to enable external analytics again.

## Article events sent to GA4

Article pages send these GA4 events when `gtag` is available:

- `article_view`
- `article_share_click`
- `article_outbound_click`
- `article_comment_submit`
- `article_scroll_25`
- `article_scroll_50`
- `article_scroll_75`
- `article_scroll_100`

Common event parameters:

- `article_text_url`
- `article_title`
- `article_section`
- `article_confirmed`

Additional parameters:

- `network` for share clicks
- `url` for outbound clicks
- `scroll_percent` for scroll-depth events

## MCP server

Use the official Google Analytics MCP server:

- Repository: `googleanalytics/google-analytics-mcp`
- Package command: `analytics-mcp`
- Required Python: 3.10+
- Access mode: read-only Analytics API access

Google Cloud requirements:

1. Create or choose a Google Cloud project.
2. Enable these APIs:
   - Google Analytics Admin API
   - Google Analytics Data API
3. Configure Application Default Credentials with the `https://www.googleapis.com/auth/analytics.readonly` scope.
4. Ensure the authenticated user or service account has at least Viewer access to the GA4 property.

For this site the production GA4 identifiers are:

```text
GA4 Measurement ID: G-KH9L14NJ44
GA4 Property ID: 397087119
Google Cloud Project ID: ampleev-analytics-mcp
Service Account: ampleev-ga4-mcp-viewer@ampleev-analytics-mcp.iam.gserviceaccount.com
```

If the GA4 UI rejects the service account email with “does not match a Google account”, add it through the official Analytics Admin API `properties.accessBindings.create` endpoint instead:

```json
{
  "parent": "properties/397087119",
  "requestBody": {
    "user": "ampleev-ga4-mcp-viewer@ampleev-analytics-mcp.iam.gserviceaccount.com",
    "roles": [
      "predefinedRoles/viewer"
    ]
  }
}
```

Recommended local credentials path:

```text
/Users/eampleev/.config/google-analytics-mcp/application_default_credentials.json
```

Do not commit credentials or service-account JSON files to this repository.

Example MCP server configuration shape:

```json
{
  "mcpServers": {
    "analytics-mcp": {
      "command": "analytics-mcp",
      "env": {
        "GOOGLE_APPLICATION_CREDENTIALS": "/Users/eampleev/.config/google-analytics-mcp/application_default_credentials.json",
        "GOOGLE_CLOUD_PROJECT": "YOUR_GOOGLE_CLOUD_PROJECT_ID"
      }
    }
  }
}
```

Useful prompts after MCP is connected:

- `Какие страницы получили больше всего активных пользователей за последние 7 дней?`
- `Покажи источники трафика за последние 30 дней.`
- `Сравни RU и EN страницы по просмотрам за месяц.`
- `Какие события article_scroll_25/50/75/100 чаще всего достигаются по статьям?`
