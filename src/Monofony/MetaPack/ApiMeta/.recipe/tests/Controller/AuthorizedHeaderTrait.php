<?php

declare(strict_types=1);

namespace App\Tests\Controller;

trait AuthorizedHeaderTrait
{
    private static array $authorizedHeaderWithContentType = [
        'HTTP_Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDY2OTE1NzksImV4cCI6MTk2MjA1MTU3OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoic3lsaXVzIn0.hq78_GyCVSj6lholihJeXFKpp5UYd3Jeyll6Ko6KUAZ7OD3k_kQfZ5MimNhfxExexzNhJ1wjFuKl58tBLI0hm6umRa4sFKV3AMfNYSPTZAlURD1MpifJGNO6sML8FfDalomk4c1X-EnHqP4gbcAJ7O2uZcvDOYuZ32r75Z0SBR2QXMoPHbyxVM7_Lu4f4NI8odz9xKhNuV7WyFDZwrGnvJDvzdbtfyxKxsyO4GE2T3_hMYZz4FvfvwScjxSjOKU9F0hLDaapGOq5XFXzZnZqHSgRebYzpq62Bac6FOHlQnlKRWJoSZKJaC-bc0lGNMjCB72bHTx4fPXQ3auNikTPLA',
        'CONTENT_TYPE' => 'application/json',
    ];

    private static array $authorizedHeaderWithAccept = [
        'HTTP_Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDY2OTE1NzksImV4cCI6MTk2MjA1MTU3OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoic3lsaXVzIn0.hq78_GyCVSj6lholihJeXFKpp5UYd3Jeyll6Ko6KUAZ7OD3k_kQfZ5MimNhfxExexzNhJ1wjFuKl58tBLI0hm6umRa4sFKV3AMfNYSPTZAlURD1MpifJGNO6sML8FfDalomk4c1X-EnHqP4gbcAJ7O2uZcvDOYuZ32r75Z0SBR2QXMoPHbyxVM7_Lu4f4NI8odz9xKhNuV7WyFDZwrGnvJDvzdbtfyxKxsyO4GE2T3_hMYZz4FvfvwScjxSjOKU9F0hLDaapGOq5XFXzZnZqHSgRebYzpq62Bac6FOHlQnlKRWJoSZKJaC-bc0lGNMjCB72bHTx4fPXQ3auNikTPLA',
        'ACCEPT' => 'application/json',
    ];

    private static array $authorizedHeaderForPatch = [
        'HTTP_Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDY2OTE1NzksImV4cCI6MTk2MjA1MTU3OSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoic3lsaXVzIn0.hq78_GyCVSj6lholihJeXFKpp5UYd3Jeyll6Ko6KUAZ7OD3k_kQfZ5MimNhfxExexzNhJ1wjFuKl58tBLI0hm6umRa4sFKV3AMfNYSPTZAlURD1MpifJGNO6sML8FfDalomk4c1X-EnHqP4gbcAJ7O2uZcvDOYuZ32r75Z0SBR2QXMoPHbyxVM7_Lu4f4NI8odz9xKhNuV7WyFDZwrGnvJDvzdbtfyxKxsyO4GE2T3_hMYZz4FvfvwScjxSjOKU9F0hLDaapGOq5XFXzZnZqHSgRebYzpq62Bac6FOHlQnlKRWJoSZKJaC-bc0lGNMjCB72bHTx4fPXQ3auNikTPLA',
        'CONTENT_TYPE' => 'application/merge-patch+json',
    ];
}
