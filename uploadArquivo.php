<?PHP 
class uploadArquivo{
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
}