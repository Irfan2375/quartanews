#!/usr/bin/env bash
set -e
BASE="http://quartanews.test"
JAR=$(mktemp)
echo "== 1. guest akses admin list harus 302 ke login =="
curl -s -o /dev/null -w "admin list (guest): %{http_code} -> %{redirect_url}\n" "$BASE/admin/articles"

echo "== 2. GET login page (ambil CSRF) =="
LOGIN=$(curl -s -c "$JAR" "$BASE/login")
TOKEN=$(echo "$LOGIN" | grep -o 'name="_token" value="[^"]*"' | sed 's/.*value="\([^"]*\)".*/\1/')
echo "csrf token: ${TOKEN:0:12}..."

echo "== 3. POST login =="
curl -s -b "$JAR" -c "$JAR" -o /dev/null -w "login POST: %{http_code} -> %{redirect_url}\n" \
  -d "_token=$TOKEN" -d "email=admin@quartanews.test" -d "password=password123" \
  "$BASE/login"

echo "== 4. admin list setelah login =="
curl -s -b "$JAR" -o /tmp/adm_list.html -w "admin list (auth): %{http_code}\n" "$BASE/admin/articles"
grep -o "Daftar\|Admin\|admin@quartanews" /tmp/adm_list.html | head -1

echo "== 5. CREATE artikel =="
FORM=$(curl -s -b "$JAR" "$BASE/admin/articles/create")
CTOK=$(echo "$FORM" | grep -o 'name="_token" value="[^"]*"' | sed 's/.*value="\([^"]*\)".*/\1/' | head -1)
curl -s -b "$JAR" -c "$JAR" -o /dev/null -w "store POST: %{http_code} -> %{redirect_url}\n" \
  -d "_token=$CTOK" \
  -d "title=Test CRUD Artikel Gebi" \
  -d "category=teknologi" \
  -d "author=Irfan Test" \
  -d "excerpt=Ini ringkasan artikel uji coba CRUD." \
  -d "body=<p>Isi artikel uji coba yang dibuat lewat form admin.</p>" \
  -d "is_published=1" \
  "$BASE/admin/articles"

echo "== 6. cek artikel masuk ke DB =="
php "C:/laragon/www/quartanews/artisan" tinker --execute="\$a=\App\Models\Article::where('title','Test CRUD Artikel Gebi')->first(); echo \$a ? 'FOUND id='.\$a->id.' slug='.\$a->slug : 'NOT_FOUND';" 2>&1 | tail -1

echo "== 7. EDIT artikel =="
AID=$(php "C:/laragon/www/quartanews/artisan" tinker --execute="echo \App\Models\Article::where('title','Test CRUD Artikel Gebi')->first()->id;" 2>/dev/null | tail -1)
EFORM=$(curl -s -b "$JAR" "$BASE/admin/articles/$AID/edit")
ETOK=$(echo "$EFORM" | grep -o 'name="_token" value="[^"]*"' | sed 's/.*value="\([^"]*\)".*/\1/' | head -1)
curl -s -b "$JAR" -o /dev/null -w "update PUT: %{http_code} -> %{redirect_url}\n" \
  -d "_token=$ETOK" -d "_method=PUT" \
  -d "title=Test CRUD Artikel Gebi (Edited)" \
  -d "category=politik" \
  -d "author=Irfan Test" \
  -d "excerpt=Ringkasan sudah diedit." \
  -d "body=<p>Isi sudah diedit.</p>" \
  -d "is_published=1" \
  "$BASE/admin/articles/$AID"
php "C:/laragon/www/quartanews/artisan" tinker --execute="\$a=\App\Models\Article::find($AID); echo 'AFTER_EDIT title=['.\$a->title.'] cat=['.\$a->category.']';" 2>&1 | tail -1

echo "== 8. DELETE artikel =="
DTOK=$(curl -s -b "$JAR" "$BASE/admin/articles" | grep -o 'name="_token" value="[^"]*"' | sed 's/.*value="\([^"]*\)".*/\1/' | head -1)
curl -s -b "$JAR" -o /dev/null -w "delete POST: %{http_code} -> %{redirect_url}\n" \
  -d "_token=$DTOK" -d "_method=DELETE" \
  "$BASE/admin/articles/$AID"
php "C:/laragon/www/quartanews/artisan" tinker --execute="echo \App\Models\Article::find($AID) ? 'STILL_EXISTS' : 'DELETED_OK';" 2>&1 | tail -1

echo "== 9. logout =="
LTOK=$(curl -s -b "$JAR" "$BASE/admin/articles" | grep -o 'name="_token" value="[^"]*"' | sed 's/.*value="\([^"]*\)".*/\1/' | head -1)
curl -s -b "$JAR" -o /dev/null -w "logout POST: %{http_code} -> %{redirect_url}\n" -d "_token=$LTOK" "$BASE/logout"
curl -s -o /dev/null -w "admin list after logout: %{http_code} -> %{redirect_url}\n" "$BASE/admin/articles"

rm -f "$JAR"
echo "== DONE =="
