<?PHP 
class uploadArquivo{
    /**
        * === Notas: upload de arquivo via AJAX ===
        *
        * Passo a passo:
        * 1. Formulário precisa de `enctype="multipart/form-data"` e campos `type="file"`.
        * 2. No JavaScript, criar `const formData = new FormData(formElement);` e acrescentar todos os campos.
        * 3. Enviar o `FormData` com fetch/axios/jQuery configurado com `processData: false` e `contentType: false`
        *    para o payload seguir como multipart.
        * 4. No PHP:
        *      - Conferir se `$_FILES['campo']['name']` existe e se `is_uploaded_file($_FILES['campo']['tmp_name'])` retorna true.
        *      - Sanitizar o nome, criar a pasta destino (se não existir) e chamar `move_uploaded_file`.
        *      - Guardar apenas o caminho relativo que será usado no front-end/banco.
        * 5. Retornar JSON com `success` e `message` para o front-end tratar o resultado.
        * 6. Use `dirname(__DIR__)` ou similar para formar caminhos absolutos seguros.
    **/
    function uploadArquivo(String $arquivo, String $pastaDestino, String $caminhoRelativo){
        if (empty($_FILES[$arquivo]['name'])) { // Verifica se não está vazio
            return null;
        }

        $tmpName = $_FILES[$arquivo]['tmp_name'];
        if (!is_uploaded_file($tmpName)) { // Verififca se foi feito upload da forma correta
            return null;
        }

        $nomeArquivo = $this->sanitizarNomeArquivo($_FILES[$arquivo]['name']);
        $destinoNormalizado = rtrim($pastaDestino, '/\\') . DIRECTORY_SEPARATOR; // Remove barras duplicadas e adiciona um único separador

        if (!is_dir($destinoNormalizado)) { // Cria diretório se não existir
            mkdir($destinoNormalizado, 0775, true);
        }

        if (move_uploaded_file($tmpName, $destinoNormalizado . $nomeArquivo)) { // Faz a movimentaçao pra pasta
            return $caminhoRelativo.$nomeArquivo;
        }

        return null;
    }

    private function sanitizarNomeArquivo(string $nomeOriginal): string{
        $semAcento = $this->removerAcentos($nomeOriginal);
        $semEspaco = preg_replace('/\s+/', '_', $semAcento);
        $limpo = preg_replace('/[^A-Za-z0-9_\.\-]/', '', $semEspaco);
        return $limpo;
    }

    private function removerAcentos(string $string): string {
        $caracteres_sem_acento = array(
            '?'=>'S', '?'=>'s', '?'=>'Z', '?'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'İ'=>'Y', 'Ş'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ğ'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ı'=>'y', 'ş'=>'b', 'ÿ'=>'y'
        );

        return strtr($string, $caracteres_sem_acento);
    }
}