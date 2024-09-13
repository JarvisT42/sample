import time
import os

# Animation parameters
width = 30
delay = 0.05

# Initial position and direction of the ball
pos = 0
direction = 1

# Function to clear the screen
def clear_screen():
    os.system('cls')

while True:
    clear_screen()
    # Draw the current frame
    print(' ' * pos + 'O')
    
    # Update ball position and direction
    pos += direction
    if pos == width or pos == 0:
        direction *= -1  # Reverse the direction when hitting the wall
    
    # Delay between frames
    time.sleep(delay)
