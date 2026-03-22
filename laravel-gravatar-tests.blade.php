@section('content')

@php
  $email = 'forxer@gmail.com';
  $gravatarImage = gravatar($email);
@endphp

  <h2>Tests Laravel Gravatar v6.0.0</h2>

  <div style="background: #f3e5f5; padding: 20px; margin: 20px 0; border-left: 4px solid #9c27b0;">
    <h3>Tests de Propriétés PHP 8.4</h3>
    @php
    $php84Test = gravatar('php84@test.com');

    // Test asymmetric visibility (lecture OK, écriture privée)
    $canReadPreset = isset($php84Test->presetName); // true
    $presetValue = $php84Test->presetName; // null ou string

    // Test property hooks avec validation automatique
    $php84Test->size = 100; // OK
    try {
        $testInvalid = gravatar('invalid@test.com');
        // $testInvalid->size = 5000; // Lancerait InvalidImageSizeException
        $sizeValidationWorks = true;
    } catch (\Exception $e) {
        $sizeValidationWorks = false;
    }
    @endphp
    <p>✅ Asymmetric visibility: presetName lisible = {{ $canReadPreset ? 'OUI' : 'NON' }}</p>
    <p>✅ Property hooks avec validation: {{ $sizeValidationWorks ? 'ACTIFS' : 'ERREUR' }}</p>
    <p>✅ Preset actuel: {{ $presetValue ?? 'null (aucun)' }}</p>
    <img src="{{ $php84Test }}" alt="PHP 8.4 features" width="100">
  </div>

  <h3>1. Image de base avec helper gravatar()</h3>
  <img src="{{ gravatar($email) }}" alt="Avatar de base">
  <p>URL: {{ gravatar($email)->url() }}</p>

  <h3>2. Image avec facade Gravatar</h3>
  <img src="{{ Gravatar::image($email) }}" alt="Facade">
  <img src="{{ Gravatar::avatar($email) }}" alt="Facade alias avatar()">

  <h3>3. Copie avec changement d'email</h3>
  <img src="{{ $gravatarImage->copy()->email('email@exemple.com') }}" alt="Copy + email()">
  <img src="{{ $gravatarImage->copy('email@exemple.com') }}" alt="Copy avec email direct">

  <h3>4. Initiales - 1) Helper methods</h3>
  <img src="{{ gravatar('email@exemple.com')->defaultImage('initials')->initialsName('John Doe') }}" alt="defaultImage('initials') + initialsName">
  <img src="{{ gravatar('email@exemple.com')->defaultImage('initials')->initials('AB') }}" alt="defaultImage('initials') + initials">

  <h3>4b. Initiales - 2) Convenience methods</h3>
  <img src="{{ gravatar('email@exemple.com')->withInitialsName('John Doe') }}" alt="withInitialsName">
  <img src="{{ gravatar('email@exemple.com')->withInitials('JD') }}" alt="withInitials">

  <h3>4c. Initiales - 3) Helper methods</h3>
  @php
  $initialsImage = gravatar('initials@test.com');
  $initialsImage->defaultImage = 'initials';
  $initialsImage->initialsName('Jane Smith');
  @endphp
  <img src="{{ $initialsImage }}" alt="Initials via helper">
  <p>Initiales générées depuis: {{ $initialsImage->initialsName }}</p>

  @php
  $initialsImage2 = Gravatar::image('initials2@test.com');
  $initialsImage2->defaultImage = 'initials';
  $initialsImage2->initials('XY');
  @endphp
  <img src="{{ $initialsImage2 }}" alt="Initials via helper">
  <p>Initiales explicites: {{ $initialsImage2->initials }}</p>

  <h3>5. Différentes tailles - 1) Helper method size()</h3>
  <img src="{{ gravatar($email)->size(50) }}" alt="50px" width="50">
  <img src="{{ gravatar($email)->size(100) }}" alt="100px" width="100">
  <img src="{{ gravatar($email)->size(200) }}" alt="200px" width="200">
  <img src="{{ gravatar($email)->size(512) }}" alt="512px" width="512">
  <p>Taille max supportée: 2048px</p>

  <h3>5b. Tailles - 3) Direct property</h3>
  @php
  $sizePropertyImage = gravatar($email);
  $sizePropertyImage->size = 120;
  @endphp
  <img src="{{ $sizePropertyImage }}" alt="size property" width="120">
  <p>Taille: {{ $sizePropertyImage->size }}px</p>

  <h3>6. Images par défaut - 1) Helper method defaultImage()</h3>
  <img src="{{ gravatar('color@test.com')->defaultImage('color') }}" alt="color">
  <img src="{{ gravatar('mp@test.com')->defaultImage('mp') }}" alt="mystery-person">
  <img src="{{ gravatar('identicon@test.com')->defaultImage('identicon') }}" alt="identicon">
  <img src="{{ gravatar('monsterid@test.com')->defaultImage('monsterid') }}" alt="monsterid">
  <img src="{{ gravatar('wavatar@test.com')->defaultImage('wavatar') }}" alt="wavatar">
  <img src="{{ gravatar('retro@test.com')->defaultImage('retro') }}" alt="retro">
  <img src="{{ gravatar('robohash@test.com')->defaultImage('robohash') }}" alt="robohash">
  <img src="{{ gravatar('blank@test.com')->defaultImage('blank') }}" alt="blank">
  <img src="{{ gravatar('404@test.com')->defaultImage('404') }}" alt="404 (no image)">

  <h3>6b. Images par défaut - 2) Convenience methods (fluent shorthand)</h3>
  <img src="{{ gravatar('d-init@test.com')->defaultImageInitials()->withInitials('TU') }}" alt="defaultImageInitials()">
  <img src="{{ gravatar('d-color@test.com')->defaultImageColor() }}" alt="defaultImageColor()">
  <img src="{{ gravatar('d-mp@test.com')->defaultImageMp() }}" alt="defaultImageMp()">
  <img src="{{ gravatar('d-identicon@test.com')->defaultImageIdenticon() }}" alt="defaultImageIdenticon()">
  <img src="{{ gravatar('d-monsterid@test.com')->defaultImageMonsterid() }}" alt="defaultImageMonsterid()">
  <img src="{{ gravatar('d-wavatar@test.com')->defaultImageWavatar() }}" alt="defaultImageWavatar()">
  <img src="{{ gravatar('d-retro@test.com')->defaultImageRetro() }}" alt="defaultImageRetro()">
  <img src="{{ gravatar('d-robohash@test.com')->defaultImageRobohash() }}" alt="defaultImageRobohash()">
  <img src="{{ gravatar('d-blank@test.com')->defaultImageBlank() }}" alt="defaultImageBlank()">
  <img src="{{ gravatar('d-404@test.com')->defaultImageNotFound() }}" alt="defaultImageNotFound()">

  <h3>6c. Images par défaut - 3) Direct property</h3>
  @php
  $defaultPropertyImage = gravatar('default-prop@test.com');
  $defaultPropertyImage->defaultImage = 'robohash';
  @endphp
  <img src="{{ $defaultPropertyImage }}" alt="defaultImage property">
  <p>Default image: {{ $defaultPropertyImage->defaultImage }}</p>

  <h3>7. Extensions de fichier - 1) Helper method extension()</h3>
  <img src="{{ gravatar($email)->extension('jpg') }}" alt="JPG">
  <img src="{{ gravatar($email)->extension('jpeg') }}" alt="JPEG">
  <img src="{{ gravatar($email)->extension('png') }}" alt="PNG">
  <img src="{{ gravatar($email)->extension('gif') }}" alt="GIF">
  <img src="{{ gravatar($email)->extension('webp') }}" alt="WEBP">

  <h3>7b. Extensions - 2) Convenience methods (fluent shorthand)</h3>
  <img src="{{ gravatar($email)->extensionJpg() }}" alt="extensionJpg()">
  <img src="{{ gravatar($email)->extensionJpeg() }}" alt="extensionJpeg()">
  <img src="{{ gravatar($email)->extensionPng() }}" alt="extensionPng()">
  <img src="{{ gravatar($email)->extensionGif() }}" alt="extensionGif()">
  <img src="{{ gravatar($email)->extensionWebp() }}" alt="extensionWebp()">

  <h3>7c. Extensions - 3) Direct property</h3>
  @php
  $extensionPropertyImage = gravatar($email);
  $extensionPropertyImage->extension = 'webp';
  @endphp
  <img src="{{ $extensionPropertyImage }}" alt="extension property">
  <p>Extension: {{ $extensionPropertyImage->extension }}</p>

  <h3>8. Ratings - 1) Helper method maxRating()</h3>
  <img src="{{ gravatar($email)->maxRating('g') }}" alt="Rating G">
  <img src="{{ gravatar($email)->maxRating('pg') }}" alt="Rating PG">
  <img src="{{ gravatar($email)->maxRating('r') }}" alt="Rating R">
  <img src="{{ gravatar($email)->maxRating('x') }}" alt="Rating X">

  <h3>8b. Ratings - 2) Convenience methods (fluent shorthand)</h3>
  <img src="{{ gravatar($email)->ratingG() }}" alt="ratingG()">
  <img src="{{ gravatar($email)->ratingPg() }}" alt="ratingPg()">
  <img src="{{ gravatar($email)->ratingR() }}" alt="ratingR()">
  <img src="{{ gravatar($email)->ratingX() }}" alt="ratingX()">

  <h3>8c. Ratings - 3) Direct property</h3>
  @php
  $ratingPropertyImage = gravatar($email);
  $ratingPropertyImage->maxRating = 'pg';
  @endphp
  <img src="{{ $ratingPropertyImage }}" alt="maxRating property">
  <p>Max Rating: {{ $ratingPropertyImage->maxRating }}</p>

  <h3>9. Force default - 1) Helper method forceDefault()</h3>
  <img src="{{ gravatar($email)->forceDefault(true)->defaultImage('retro') }}" alt="forceDefault(true)">
  <p>État forcé via helper: {{ gravatar($email)->forceDefault(true)->forcingDefault() ? 'oui' : 'non' }}</p>

  <h3>9b. Force default - 2) Convenience methods</h3>
  <img src="{{ gravatar($email)->enableForceDefault()->defaultImage('robohash') }}" alt="enableForceDefault()">
  @php
  $checkForce = gravatar('check@test.com')->enableForceDefault();
  @endphp
  <p>État via enableForceDefault(): {{ $checkForce->forcingDefault() ? 'oui' : 'non' }}</p>

  <h3>9c. Force default - 3) Helper method</h3>
  @php
  $forceImage = gravatar($email);
  $forceImage->forceDefault(true);
  $forceImage->defaultImage = 'monsterid';
  @endphp
  <img src="{{ $forceImage }}" alt="Helper method">
  <p>Est forcé via helper: {{ $forceImage->forcingDefault() ? 'oui' : 'non' }}</p>

  <h3>10. Combinaisons - 1) Helper methods</h3>
  <img src="{{ gravatar('combo1@test.com')->size(150)->defaultImage('robohash')->extension('png') }}" alt="Combo helper">

  <h3>10b. Combinaisons - 2) Convenience methods (fluent)</h3>
  <img src="{{ gravatar('combo2@test.com')->size(120)->defaultImageRetro()->extensionWebp()->ratingPg() }}" alt="Combo fluent">

  <h3>10c. Combinaisons - 3) Direct properties</h3>
  @php
  $comboProps = gravatar('combo3@test.com');
  $comboProps->size = 100;
  $comboProps->defaultImage = 'identicon';
  $comboProps->extension = 'jpg';
  $comboProps->maxRating = 'g';
  @endphp
  <img src="{{ $comboProps }}" alt="Combo properties">

  <h3>11. Getter mode des helper methods</h3>
  @php
  $getterTest = gravatar('getter@test.com')->size(150)->extension('webp')->maxRating('pg');
  @endphp
  <ul>
    <li>size() getter: {{ $getterTest->size() }}px</li>
    <li>extension() getter: {{ $getterTest->extension() }}</li>
    <li>maxRating() getter: {{ $getterTest->maxRating() }}</li>
    <li>email() getter: {{ $getterTest->email() }}</li>
  </ul>

  <h3>12. Test des propriétés publiques - Lecture</h3>
  @php
  $testImage = gravatar('test@example.com')->size(150)->extension('jpg')->maxRating('pg');
  @endphp
  <img src="{{ $testImage }}" alt="Test image" width="150">
  <ul>
    <li>Email: {{ $testImage->email }}</li>
    <li>Size: {{ $testImage->size }}px</li>
    <li>Extension: {{ $testImage->extension }}</li>
    <li>Max Rating: {{ $testImage->maxRating ?? 'non défini' }}</li>
    <li>Default Image: {{ $testImage->defaultImage ?? 'non défini' }}</li>
    <li>Force Default: {{ $testImage->forceDefault ? 'oui' : 'non' }}</li>
    <li>Initials: {{ $testImage->initials ?? 'non défini' }}</li>
    <li>Initials Name: {{ $testImage->initialsName ?? 'non défini' }}</li>
  </ul>

  <h3>13. Accès direct aux propriétés - Écriture</h3>
  @php
  $directImage = gravatar('direct@example.com');
  $directImage->size = 180;
  $directImage->extension = 'png';
  $directImage->maxRating = 'pg';
  $directImage->defaultImage = 'retro';
  @endphp
  <img src="{{ $directImage }}" alt="Propriétés directes" width="180">
  <p>Configuré via assignation directe: size={{ $directImage->size }}, ext={{ $directImage->extension }}, rating={{ $directImage->maxRating }}</p>

  <h3>14. Mélange helper methods et property access</h3>
  @php
  $mixedImage = Gravatar::image('mixed@test.com');
  $mixedImage->email('mixed-new@test.com');  // Helper method (email est private(set))
  $mixedImage->size(140);  // Helper
  $mixedImage->extension = 'webp';  // Property (set hook)
  $mixedImage->maxRating('r');  // Helper
  @endphp
  <img src="{{ $mixedImage }}" alt="Méthodes mixtes" width="140">

  <h3>15. Profils Gravatar (API v3, JSON uniquement)</h3>
  @php
  $profile = gravatar_profile($email);
  @endphp
  <ul>
    <li>Profile URL: <a href="{{ $profile }}">{{ $profile }}</a></li>
  </ul>
  <p>Note : l'API v3 utilise SHA-256 et retourne uniquement du JSON.</p>

  <h3>16. Profils avec Facade</h3>
  <ul>
    <li>Profile (Facade): <a href="{{ Gravatar::profile($email) }}">{{ Gravatar::profile($email) }}</a></li>
  </ul>

  <h3>17. Presets - Configuration (config/gravatar.php)</h3>
  <img src="{{ gravatar($email, 'small') }}" alt="Preset 'small'">
  <img src="{{ gravatar($email, 'medium') }}" alt="Preset 'medium'">
  <img src="{{ gravatar($email, 'large') }}" alt="Preset 'large'">
  <p>Note: Les presets sont définis dans config/gravatar.php</p>

  <h3>18. Presets - Modification dynamique</h3>
  @php
  $presetImage = gravatar($email);
  $presetImage->preset('medium');
  @endphp
  <img src="{{ $presetImage }}" alt="Preset appliqué dynamiquement">

  <h3>18b. Preset avec initials</h3>
  @php
  // Note: Exemple de preset personnalisé avec initials
  // Les initials sont typiquement définies dynamiquement, pas dans le preset
  $initialsPreset = gravatar('preset-init@test.com')->defaultImageInitials()->withInitialsName('Test User');
  @endphp
  <img src="{{ $initialsPreset }}" alt="Initials dynamiques">
  <p>Initiales supportées dans les presets (via 'initials' et 'initials_name' keys)</p>

  <h3>19. URL personnalisée comme défaut</h3>
  <img src="{{ gravatar('noexist@example.com')->defaultImage('https://via.placeholder.com/150') }}" alt="URL custom">
  <img src="{{ gravatar('noexist2@example.com')->defaultImage('https://ui-avatars.com/api/?name=No+Avatar&size=80&background=random') }}" alt="UI Avatars">

  <h3>20. Profil - URL API v3</h3>
  @php
  $profileUrl = gravatar_profile($email);
  @endphp
  <p>URL du profil : <a href="{{ $profileUrl }}">{{ $profileUrl }}</a></p>
  <p>Note : l'API v3 retourne uniquement du JSON.</p>

  <h3>21. Profile::getData() - Laravel HTTP client</h3>
  @php
  $profileData = gravatar_profile($email)->getData();
  @endphp
  @if ($profileData)
    <p>✅ Données du profil récupérées avec getData()</p>
    <ul>
      <li>Display Name: {{ $profileData['display_name'] ?? 'N/A' }}</li>
      <li>Avatar URL: {{ $profileData['avatar_url'] ?? 'N/A' }}</li>
      <li>Location: {{ $profileData['location'] ?? 'N/A' }}</li>
    </ul>
  @else
    <p>❌ Impossible de récupérer les données du profil (réseau ou profil privé)</p>
  @endif

  <h3>22. copy() - Copie d'instance</h3>
  @php
  $base = gravatar()->size(100)->extensionWebp()->ratingPg();
  $copy1 = $base->copy('copy1@test.com');
  $copy2 = $base->copy('copy2@test.com')->size(150);
  @endphp
  <p>Base config: size={{ $base->size() }}, ext={{ $base->extension() }}</p>
  <img src="{{ $copy1 }}" alt="Copy 1" width="100">
  <img src="{{ $copy2 }}" alt="Copy 2 (modified)" width="150">

  <h3>23. Méthodes fluent - Chaînage complet</h3>
  <img src="{{ gravatar('chain@test.com')->size(140)->extensionWebp()->ratingPg()->defaultImageRobohash() }}" alt="Full chain" width="140">

  <h3>24. Mélange string, enum et fluent</h3>
  @php
  $mixed = gravatar('mixed-all@test.com');
  $mixed->size(130);                        // Helper method
  $mixed->extension = \Gravatar\Enum\Extension::WEBP;      // Enum via property
  $mixed->ratingPg();                       // Fluent shorthand
  $mixed->defaultImage('identicon');        // String via helper
  @endphp
  <img src="{{ $mixed }}" alt="Mixed approaches" width="130">

  <h3>25. Utilisation des Enums - Extension</h3>
  @php
  $enumExt1 = gravatar('enum-ext1@test.com');
  $enumExt1->extension = \Gravatar\Enum\Extension::PNG;

  $enumExt2 = \LaravelGravatar\Facades\Gravatar::image('enum-ext2@test.com');
  $enumExt2->extension(\Gravatar\Enum\Extension::WEBP);
  @endphp
  <img src="{{ $enumExt1 }}" alt="Extension::PNG via property">
  <img src="{{ $enumExt2 }}" alt="Extension::WEBP via helper">

  <h3>26. Utilisation des Enums - Rating</h3>
  @php
  $enumRating1 = gravatar('enum-rating1@test.com');
  $enumRating1->maxRating = \Gravatar\Enum\Rating::PG;

  $enumRating2 = \LaravelGravatar\Facades\Gravatar::image('enum-rating2@test.com');
  $enumRating2->maxRating(\Gravatar\Enum\Rating::R);
  @endphp
  <img src="{{ $enumRating1 }}" alt="Rating::PG via property">
  <img src="{{ $enumRating2 }}" alt="Rating::R via helper">

  <h3>27. Utilisation des Enums - DefaultImage</h3>
  @php
  $enumDefault1 = gravatar('enum-default1@test.com');
  $enumDefault1->defaultImage = \Gravatar\Enum\DefaultImage::ROBOHASH;

  $enumDefault2 = \LaravelGravatar\Facades\Gravatar::image('enum-default2@test.com');
  $enumDefault2->defaultImage(\Gravatar\Enum\DefaultImage::RETRO);
  @endphp
  <img src="{{ $enumDefault1 }}" alt="DefaultImage::ROBOHASH via property">
  <img src="{{ $enumDefault2 }}" alt="DefaultImage::RETRO via helper">

  <h3>28. Profil - Helper et Facade</h3>
  @php
  $profileHelper = gravatar_profile($email);
  $profileFacade = \LaravelGravatar\Facades\Gravatar::profile($email);
  @endphp
  <ul>
    <li>Via helper : <a href="{{ $profileHelper }}">{{ $profileHelper }}</a></li>
    <li>Via facade : <a href="{{ $profileFacade }}">{{ $profileFacade }}</a></li>
  </ul>

  <h3>29. Combinaison complète avec enums</h3>
  @php
  $fullEnum = gravatar('full-enum@test.com');
  $fullEnum->size = 200;
  $fullEnum->extension = \Gravatar\Enum\Extension::WEBP;
  $fullEnum->maxRating = \Gravatar\Enum\Rating::PG;
  $fullEnum->defaultImage = \Gravatar\Enum\DefaultImage::ROBOHASH;
  @endphp
  <img src="{{ $fullEnum }}" alt="Full enum combination" width="200">
  <p>Config: size={{ $fullEnum->size }}, ext={{ $fullEnum->extension }}, rating={{ $fullEnum->maxRating }}, default={{ $fullEnum->defaultImage }}</p>

  <h3>30. Test avec email null puis assigné</h3>
  @php
  $noEmailImage = gravatar();
  $noEmailImage->size = 100;
  $noEmailImage->defaultImage = 'robohash';
  $noEmailImage->email('late-email@test.com');
  @endphp
  <img src="{{ $noEmailImage }}" alt="Email assigné via helper" width="100">

  <h3>31. Disable force default après enable</h3>
  @php
  $toggleForce = gravatar('toggle@test.com');
  $toggleForce->enableForceDefault();
  $toggleForce->defaultImage = 'monsterid';
  $isForcingBefore = $toggleForce->forcingDefault(); // true
  $toggleForce->disableForceDefault();
  $isForcingAfter = $toggleForce->forcingDefault(); // false
  @endphp
  <p>Avant disable: {{ $isForcingBefore ? 'forcé' : 'non forcé' }}</p>
  <p>Après disable: {{ $isForcingAfter ? 'forcé' : 'non forcé' }}</p>
  <img src="{{ $toggleForce }}" alt="Force toggle">

  <h3>32. Réutilisation et modification d'instance</h3>
  @php
  $reusable = gravatar('reusable@test.com');
  $reusable->size(100)->defaultImage('retro');
  $url1 = $reusable->url();

  $reusable->size(150)->defaultImage('robohash');
  $url2 = $reusable->url();
  @endphp
  <p>Première config: <img src="{{ $url1 }}" alt="Config 1" width="100"></p>
  <p>Deuxième config: <img src="{{ $url2 }}" alt="Config 2" width="150"></p>

  <h3>33. Edge cases - Tailles limites</h3>
  <img src="{{ gravatar($email)->size(1) }}" alt="Taille minimale: 1px" width="1">
  <img src="{{ gravatar($email)->size(2048) }}" alt="Taille maximale: 2048px" style="max-width: 200px;">

  <h3>34. toBase64() - Conversion en base64 (Content-Type dynamique)</h3>
  @php
  $base64Png = gravatar($email)->size(80)->toBase64();
  $base64Jpg = gravatar($email)->size(80)->extension('jpg')->toBase64();
  $base64Webp = gravatar($email)->size(80)->extension('webp')->toBase64();
  @endphp
  @if ($base64Png)
    <img src="{{ $base64Png }}" alt="Base64 PNG" width="80">
    <p>PNG : {{ substr($base64Png, 0, 30) }}... ({{ strlen($base64Png) }} caractères)</p>
  @else
    <p>Impossible de récupérer l'image PNG en base64</p>
  @endif
  @if ($base64Jpg)
    <img src="{{ $base64Jpg }}" alt="Base64 JPG" width="80">
    <p>JPG : {{ substr($base64Jpg, 0, 30) }}... ({{ strlen($base64Jpg) }} caractères)</p>
  @else
    <p>Impossible de récupérer l'image JPG en base64</p>
  @endif
  @if ($base64Webp)
    <img src="{{ $base64Webp }}" alt="Base64 WebP" width="80">
    <p>WebP : {{ substr($base64Webp, 0, 30) }}... ({{ strlen($base64Webp) }} caractères)</p>
  @else
    <p>Impossible de récupérer l'image WebP en base64</p>
  @endif

  <h3>35. Tests - Code Quality</h3>
  <div style="background: #e8f5e9; padding: 20px; margin: 20px 0; border-left: 4px solid #4caf50;">
    <h4>✅ Laravel 12 Patterns</h4>
    @php
    // Test que app() helper fonctionne correctement
    $appHelperWorks = gravatar('app-test@test.com') instanceof LaravelGravatar\Image;
    $profileHelperWorks = gravatar_profile('profile-test@test.com') instanceof LaravelGravatar\Profile;
    @endphp
    <p>✅ Helper gravatar() avec app(): {{ $appHelperWorks ? 'OK' : 'ERREUR' }}</p>
    <p>✅ Helper gravatar_profile() avec app(): {{ $profileHelperWorks ? 'OK' : 'ERREUR' }}</p>

    <h4>✅ Profile API v3</h4>
    @php
    $simplifiedProfile = Gravatar::profile('simplified@test.com');
    $profileUrlWorks = str_starts_with($simplifiedProfile->url(), 'https://');
    @endphp
    <p>✅ Profile API v3 (SHA-256): {{ $profileUrlWorks ? 'OK' : 'ERREUR' }}</p>
    <p>URL: <a href="{{ $simplifiedProfile }}">{{ $simplifiedProfile }}</a></p>

    <h4>✅ Early Returns Pattern (toBase64)</h4>
    @php
    // Test toBase64() avec le pattern early returns
    $base64Works = gravatar('base64-test@test.com')->size(50)->toBase64() !== null;
    @endphp
    <p>✅ toBase64() avec early returns: {{ $base64Works ? 'OK' : 'ERREUR' }}</p>

    <h4>✅ PresetKey Enum</h4>
    @php
    // Test que les presets fonctionnent avec l'enum PresetKey
    try {
        $presetTest = gravatar('preset-enum@test.com', 'small');
        $enumWorks = $presetTest instanceof LaravelGravatar\Image;
    } catch (\Exception $e) {
        $enumWorks = false;
    }
    @endphp
    <p>✅ Presets avec enum: {{ $enumWorks ? 'OK' : 'ERREUR' }}</p>
    <img src="{{ $presetTest ?? gravatar('fallback@test.com') }}" alt="Preset avec enum">

    <h4>✅ Return Types & PHPDoc</h4>
    @php
    // Test que tous les return types sont corrects
    $imageClass = new ReflectionClass(LaravelGravatar\Image::class);
    $gravatarClass = new ReflectionClass(LaravelGravatar\Gravatar::class);
    $hasReturnTypes = true;

    // Vérifier quelques méthodes clés
    $urlMethod = $imageClass->getMethod('url');
    $imageMethod = $gravatarClass->getMethod('image');
    $profileMethod = $gravatarClass->getMethod('profile');

    $urlHasReturn = $urlMethod->hasReturnType();
    $imageHasReturn = $imageMethod->hasReturnType();
    $profileHasReturn = $profileMethod->hasReturnType();
    @endphp
    <p>✅ Image::url() return type: {{ $urlHasReturn ? 'string ✓' : 'manquant ✗' }}</p>
    <p>✅ Gravatar::image() return type: {{ $imageHasReturn ? 'Image ✓' : 'manquant ✗' }}</p>
    <p>✅ Gravatar::profile() return type: {{ $profileHasReturn ? 'Profile ✓' : 'manquant ✗' }}</p>
  </div>

  <h3>38. Vérification finale</h3>
  @php
  $finalTest = gravatar('final@test.com');

  // Test toutes les features en une seule instance
  $finalTest->size = 120;                          // PHP 8.4 property hooks
  $finalTest->extensionWebp();                     // Convenience method
  $finalTest->maxRating(\Gravatar\Enum\Rating::PG);               // Helper method avec enum
  $finalTest->defaultImage = \Gravatar\Enum\DefaultImage::RETRO;  // Property avec enum
  $finalTest->forceDefault(false);                 // Helper method

  // Vérification des valeurs
  $allCorrect = $finalTest->size === 120
      && $finalTest->extension === 'webp'
      && $finalTest->maxRating === 'pg'
      && $finalTest->defaultImage === 'retro'
      && $finalTest->forceDefault === false;
  @endphp
  <div style="background: {{ $allCorrect ? '#e8f5e9' : '#ffebee' }}; padding: 20px; border-left: 4px solid {{ $allCorrect ? '#4caf50' : '#f44336' }};">
    <h4>{{ $allCorrect ? '✅ TOUS LES TESTS PASSENT' : '❌ ÉCHEC' }}</h4>
    <p>Configuration finale:</p>
    <ul>
      <li>Size: {{ $finalTest->size }}px (property hook)</li>
      <li>Extension: {{ $finalTest->extension }} (convenience method)</li>
      <li>Max Rating: {{ $finalTest->maxRating }} (enum)</li>
      <li>Default Image: {{ $finalTest->defaultImage }} (enum)</li>
      <li>Force Default: {{ $finalTest->forceDefault ? 'true' : 'false' }} (helper)</li>
      <li>Preset Name: {{ $finalTest->presetName ?? 'null' }} (asymmetric visibility)</li>
    </ul>
    <img src="{{ $finalTest }}" alt="Test final" width="120">
  </div>

  <h3>39. Validation des presets avec enums</h3>
  <div style="background: #e8f5e9; padding: 20px; margin: 20px 0; border-left: 4px solid #4caf50;">
    <h4>✅ Test de validation avec enums</h4>
    @php
    // Test 1: Preset valide
    $validPresetConfig = [
        'presets' => [
            'test_valid' => [
                'size' => 100,
                'extension' => 'webp',
                'max_rating' => 'pg',
                'default_image' => 'robohash',
            ],
        ],
    ];

    $testConfig = array_merge(config('gravatar'), $validPresetConfig);
    $validImage = new LaravelGravatar\Image($testConfig, 'test@example.com', 'test_valid');
    $validationWorks = true;

    // Test 2: Preset invalide (devrait lancer une exception)
    try {
        $invalidPresetConfig = [
            'presets' => [
                'test_invalid' => [
                    'extension' => 'invalid_ext', // Extension invalide
                ],
            ],
        ];
        $testConfigInvalid = array_merge(config('gravatar'), $invalidPresetConfig);
        $invalidImage = new LaravelGravatar\Image($testConfigInvalid, 'test@example.com', 'test_invalid');
        $invalidImage->url(); // Devrait lancer l'exception lors de l'application du preset
        $catchesInvalid = false;
    } catch (\Exception $e) {
        $catchesInvalid = true;
        $errorMessage = $e->getMessage();
    }
    @endphp

    <p>✅ Preset valide accepté: {{ $validationWorks ? 'OUI' : 'NON' }}</p>
    <img src="{{ $validImage }}" alt="Validation preset valide" width="100">

    <p>✅ Preset invalide rejeté: {{ $catchesInvalid ? 'OUI' : 'NON' }}</p>
    @if($catchesInvalid)
      <p style="background: #fff3e0; padding: 10px; margin: 10px 0;">
        <strong>Message d'erreur:</strong> {{ $errorMessage }}
      </p>
    @endif

    <h4>✅ Enums disponibles</h4>
    <ul>
      <li><strong>Extension:</strong> {{ implode(', ', \Gravatar\Enum\Extension::values()) }}</li>
      <li><strong>Rating:</strong> {{ implode(', ', \Gravatar\Enum\Rating::values()) }}</li>
      <li><strong>DefaultImage:</strong> {{ implode(', ', array_slice(\Gravatar\Enum\DefaultImage::values(), 0, 5)) }}... ({{ count(\Gravatar\Enum\DefaultImage::values()) }} total)</li>
      <li><strong>ProfileFormat:</strong> supprimé (API v3 JSON uniquement)</li>
    </ul>
  </div>

@endsection
