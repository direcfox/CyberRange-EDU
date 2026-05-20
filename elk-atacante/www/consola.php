<?php

$resultado = "";

$targets = [
    "metasploitable" => "192.168.1.101",
    "Usuario01" => "172.22.0.2",
    "windows" => "192.168.1.103"
];

$flagsPermitidos = [
    "-sS",
    "-sV",
    "-O",
    "-A",
    "-Pn",
    "-T4",
    "-sn",
    "--reason",
    "--packet-trace",
    "--script vuln",
    "--top-ports 50"
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $targetKey = $_POST["target"] ?? "";
    $flags = $_POST["flags"] ?? [];
    if (isset($targets[$targetKey])) {
        $ip = $targets[$targetKey];

        $comandoFlags = [];

        foreach ($flags as $flag) {
            if (in_array($flag, $flagsPermitidos)) {
                $comandoFlags[] = $flag;
            }
        }

        $comando = "sudo nmap " . implode(" ", $comandoFlags) . " " . escapeshellarg($ip) . " 2>&1";

        $resultado = shell_exec($comando);
    } else {
        $resultado = "Target no válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Laboratorio Virtual Nmap</title>
    <style>
        body {
            background: #172235;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            color: #28bfff;
        }

        .paneles {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .panel {
            border: 1px solid #34445c;
            border-radius: 8px;
            padding: 20px;
            background: #18263a;
        }

        .panel h3 {
            color: #28bfff;
            font-size: 16px;
        }

        select, label {
            display: block;
            margin: 10px 0;
        }

        select {
            width: 100%;
            padding: 10px;
            background: #0d1626;
            color: white;
            border: 1px solid #34445c;
            border-radius: 5px;
        }

        button {
            margin-top: 30px;
            width: 100%;
            padding: 18px;
            background: #35b8ee;
            color: #06101f;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .terminal-header {
            margin-top: 25px;
            background: #304058;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            font-family: monospace;
        }

        .terminal {
            background: black;
            color: white;
            padding: 20px;
            min-height: 300px;
            font-family: Consolas, monospace;
            white-space: pre-wrap;
            overflow-x: auto;
        }

        .prompt {
            color: #00bfff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Laboratorio Virtual Nmap v4.0</h1>

<form method="POST">
    <div class="paneles">
        <div class="panel">
            <h3>1. OBJETIVO</h3>
            <select name="target">
                <option value="metasploitable">Metasploitable 2</option>
                <option value="Usuario01">Usuario01</option>
                <option value="windows">Windows Server</option>
            </select>
        </div>

        <div class="panel">
            <h3>2. ESCANEO</h3>
            <label><input type="checkbox" name="flags[]" value="-sS"> -sS TCP Stealth Scan</label>
            <label><input type="checkbox" name="flags[]" value="-sV"> -sV Version Detection</label>
            <label><input type="checkbox" name="flags[]" value="-O"> -O OS Fingerprinting</label>
            <label><input type="checkbox" name="flags[]" value="--top-ports 50"> --top-ports 50</label>
        </div>

        <div class="panel">
            <h3>3. AGRESIVIDAD</h3>
            <label><input type="checkbox" name="flags[]" value="-A"> -A Aggressive</label>
            <label><input type="checkbox" name="flags[]" value="-Pn"> -Pn No Ping</label>
            <label><input type="checkbox" name="flags[]" value="-T4"> -T4 Faster</label>
            <label><input type="checkbox" name="flags[]" value="-sn"> -sn Ping Sweep</label>
        </div>

        <div class="panel">
            <h3>4. ANÁLISIS</h3>
            <label><input type="checkbox" name="flags[]" value="--reason"> --reason</label>
            <label><input type="checkbox" name="flags[]" value="--packet-trace"> --packet-trace</label>
            <label><input type="checkbox" name="flags[]" value="--script vuln"> --script vuln</label>
        </div>
    </div>

    <button type="submit">EJECUTAR ESCANEO</button>
</form>

<div class="terminal-header">
    kali@linux:~$ bash
</div>

<div class="terminal">
<?php if ($resultado): ?>
<span class="prompt">kali@linux:~$</span> nmap ...
<?= htmlspecialchars($resultado) ?>
<?php else: ?>
kali@linux:~$
<?php endif; ?>
</div>

</body>
</html>
