import unittest
from unittest.mock import patch, MagicMock
import sys
import os
import mysql.connector
from fpdf import FPDF
import qrcode
import db_config

# Configuration de la connexion à la base de données
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'olympics_ticketing'
}

class TicketGenerationTest(unittest.TestCase):

    @patch('mysql.connector.connect')
    @patch('sys.argv', ['script_name', '123'])
    def test_ticket_generation(self, mock_connect, mock_argv):
        # Simuler la connexion à la base de données
        mock_conn = MagicMock()
        mock_cursor = MagicMock()
        mock_connect.return_value = mock_conn
        mock_conn.cursor.return_value = mock_cursor

        # Simuler les données de la base de données
        mock_cursor.fetchone.return_value = ('John', 'Doe', 'VIP', 100, 'security_code_123')

        # Simuler la génération du QR code
        mock_qr = MagicMock()
        mock_qr.make_image.return_value = MagicMock()
        qrcode.QRCode = MagicMock(return_value=mock_qr)

        # Simuler la création du fichier PDF
        mock_pdf = MagicMock()
        FPDF = MagicMock(return_value=mock_pdf)

        # Appeler le script principal
        with patch('builtins.print') as mock_print:
            import ticket_generation  # Assurez-vous que ce fichier contient le script principal

        # Vérifier les appels de la base de données
        mock_cursor.execute.assert_called_once()
        mock_cursor.fetchone.assert_called_once()

        # Vérifier la génération du QR code
        mock_qr.add_data.assert_called_once_with('security_code_123')
        mock_qr.make_image.assert_called_once()

        # Vérifier la création du fichier PDF
        mock_pdf.add_page.assert_called_once()
        mock_pdf.set_font.assert_called()
        mock_pdf.cell.assert_called()
        mock_pdf.image.assert_called()
        mock_pdf.output.assert_called_once()

        # Vérifier les messages de sortie
        mock_print.assert_any_call("Début du processus pour le ticket ID: 123")
        mock_print.assert_any_call("Connexion à la base de données réussie")
        mock_print.assert_any_call("Informations du billet récupérées: John Doe, VIP, 100, security_code_123")
        mock_print.assert_any_call("Génération du QR code...")
        mock_print.assert_any_call("QR code généré avec succès")
        mock_print.assert_any_call("Création du fichier PDF...")
        mock_print.assert_any_call("PDF généré à : opt/bitnami/htdocs/paris-olympics-tickets/src/tickets/ticket_123.pdf")
        mock_print.assert_any_call("Processus terminé avec succès, billet généré: opt/bitnami/htdocs/paris-olympics-tickets/src/tickets/ticket_123.pdf")

if __name__ == '__main__':
    unittest.main()
