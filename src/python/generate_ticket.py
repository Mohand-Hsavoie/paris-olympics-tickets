import sys
import os
import mysql.connector
from fpdf import FPDF
import qrcode

# Configuration de la connexion à la base de données
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'olympics_ticketing'
}

# Récupérer l'ID du billet depuis les arguments de la ligne de commande
ticket_id = sys.argv[1]
print(f"Début du processus pour le ticket ID: {ticket_id}")

try:
    # Connexion à la base de données
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()
    print("Connexion à la base de données réussie")
except Exception as e:
    print(f"Erreur lors de la connexion à la base de données : {e}")
    sys.exit()

# Récupérer les informations du billet
try:
    ticket_query = """
        SELECT u.first_name, u.last_name, tt.name, tt.price, t.security_code
        FROM tickets t
        JOIN users u ON t.user_id = u.id
        JOIN ticket_types tt ON t.ticket_type_id = tt.id
        WHERE t.id = %s
    """
    cursor.execute(ticket_query, (ticket_id,))
    ticket = cursor.fetchone()

    if ticket is None:
        print(f"Erreur: Ticket avec ID {ticket_id} non trouvé.")
        sys.exit()

    first_name, last_name, ticket_name, ticket_price, security_code = ticket
    print(f"Informations du billet récupérées: {first_name} {last_name}, {ticket_name}, {ticket_price}, {security_code}")
except Exception as e:
    print(f"Erreur lors de la récupération des informations du billet : {e}")
    sys.exit()

# Générer le QR code
try:
    print("Génération du QR code...")
    qr = qrcode.QRCode(version=1, box_size=10, border=4)
    qr.add_data(security_code)
    qr.make(fit=True)
    qr_img = qr.make_image(fill='black', back_color='white')
    print("QR code généré avec succès")
except Exception as e:
    print(f"Erreur lors de la génération du QR code : {e}")
    sys.exit()

# Chemin du dossier pour sauvegarder les fichiers
pdf_dir = 'C:/xampp/htdocs/paris-olympics-tickets/src/tickets'
if not os.path.exists(pdf_dir):
    print(f"Création du dossier : {pdf_dir}")
    os.makedirs(pdf_dir)
else:
    print(f"Le dossier existe déjà : {pdf_dir}")

# Sauvegarder l'image QR code
try:
    qr_code_path = os.path.join(pdf_dir, f'ticket_{ticket_id}_qr.png')
    qr_img.save(qr_code_path)
    print(f"QR code enregistré à : {qr_code_path}")
except Exception as e:
    print(f"Erreur lors de la sauvegarde du QR code : {e}")
    sys.exit()

# Créer le fichier PDF
try:
    print("Création du fichier PDF...")
    pdf = FPDF()
    pdf.add_page()
    pdf.set_font('Arial', 'B', 16)
    pdf.cell(0, 10, 'Billet des Jeux Olympiques', ln=True, align='C')
    pdf.ln(10)
    pdf.set_font('Arial', '', 12)
    pdf.cell(0, 10, f'Nom: {first_name} {last_name}', ln=True)
    pdf.cell(0, 10, f'Type de billet: {ticket_name}', ln=True)
    pdf.cell(0, 10, f'Prix: {ticket_price} EUR', ln=True)
    pdf.ln(10)
    pdf.image(qr_code_path, x=10, y=pdf.get_y(), w=50)

    # Sauvegarder le PDF
    pdf_path = os.path.join(pdf_dir, f'ticket_{ticket_id}.pdf')
    pdf.output(pdf_path)
    print(f"PDF généré à : {pdf_path}")
except Exception as e:
    print(f"Erreur lors de la création ou de la sauvegarde du fichier PDF : {e}")
    sys.exit()

# Fermer la connexion à la base de données
cursor.close()
conn.close()

print(f"Processus terminé avec succès, billet généré: {pdf_path}")
